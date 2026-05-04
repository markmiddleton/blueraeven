#!/usr/bin/env python3
"""
Image Generator using Gemini API and ImageMagick

Usage:
    python generate_image.py "your prompt here" --width 1678 --height 740 --output image.jpg
    python generate_image.py "your prompt here" -w 800 -h 600 --reference ref1.jpg ref2.jpg

Requirements:
    - Python 3.8+
    - google-genai package: pip install google-genai
    - python-dotenv package: pip install python-dotenv
    - ImageMagick 7+
    - GEMINI_API_KEY in .env file or environment

Get your API key from: https://aistudio.google.com/apikey
"""

import argparse
import base64
import os
import subprocess
import sys
import tempfile
from pathlib import Path

# Load .env file from script directory
try:
    from dotenv import load_dotenv
    env_path = Path(__file__).parent / ".env"
    load_dotenv(env_path)
except ImportError:
    pass  # dotenv not installed, will use environment variables

try:
    from google import genai
except ImportError:
    print("Error: google-genai package not installed.")
    print("Install it with: pip install google-genai")
    sys.exit(1)


def load_reference_image(image_path: str) -> dict:
    """Load an image file and return it as a Gemini-compatible part."""
    import mimetypes

    # Determine mime type
    mime_type, _ = mimetypes.guess_type(image_path)
    if mime_type is None:
        # Default to JPEG for unknown types
        mime_type = "image/jpeg"

    # Read and encode the image
    with open(image_path, "rb") as f:
        image_data = f.read()

    return {
        "inline_data": {
            "mime_type": mime_type,
            "data": base64.b64encode(image_data).decode("utf-8")
        }
    }


def generate_image(prompt: str, width: int, height: int, output_path: str, model: str = "gemini-2.5-flash-image", reference_images: list = None):
    """Generate an image using Gemini API and resize with ImageMagick.

    Args:
        prompt: Text description of the image to generate
        width: Output image width in pixels
        height: Output image height in pixels
        output_path: Path to save the generated image
        model: Gemini model to use
        reference_images: Optional list of file paths to reference images for style guidance
    """

    # Check for API key
    api_key = os.environ.get("GEMINI_API_KEY")
    if not api_key:
        print("Error: GEMINI_API_KEY not found.")
        print("Either create a .env file with: GEMINI_API_KEY=your-key-here")
        print("Or set it with: export GEMINI_API_KEY='your-key-here'")
        print("Get your API key from: https://aistudio.google.com/apikey")
        sys.exit(1)

    # Initialize the client
    client = genai.Client(api_key=api_key)

    # Determine aspect ratio hint for better generation
    aspect_ratio = width / height
    if aspect_ratio > 1.7:
        aspect_hint = "wide landscape format, 16:9 or wider"
    elif aspect_ratio > 1.3:
        aspect_hint = "landscape format, roughly 3:2"
    elif aspect_ratio > 0.8:
        aspect_hint = "square format, 1:1"
    elif aspect_ratio > 0.6:
        aspect_hint = "portrait format, roughly 2:3"
    else:
        aspect_hint = "tall portrait format, 9:16 or taller"

    # Enhance prompt with aspect ratio guidance
    enhanced_prompt = f"{prompt}. Generate this image in a {aspect_hint} composition."

    print(f"Generating image with prompt: {prompt}")
    print(f"Target dimensions: {width}x{height}")
    print(f"Using model: {model}")

    # Build content parts
    content_parts = []

    # Add reference images if provided
    if reference_images:
        print(f"Using {len(reference_images)} reference image(s) for style guidance")
        for ref_path in reference_images:
            if os.path.exists(ref_path):
                content_parts.append(load_reference_image(ref_path))
                print(f"  - Loaded: {ref_path}")
            else:
                print(f"  - Warning: Reference image not found: {ref_path}")

        # Add instruction to use reference images as style guide
        enhanced_prompt = f"Using the provided reference images as a style guide, {enhanced_prompt}"

    # Add the text prompt
    content_parts.append(enhanced_prompt)

    try:
        # Generate image using Gemini
        response = client.models.generate_content(
            model=model,
            contents=content_parts,
            config={
                "response_modalities": ["TEXT", "IMAGE"]
            }
        )

        # Find and save the image from response
        temp_image_path = None
        for part in response.candidates[0].content.parts:
            if hasattr(part, 'inline_data') and part.inline_data is not None:
                # Get image data
                image_data = part.inline_data.data
                mime_type = part.inline_data.mime_type

                # Determine extension from mime type
                ext = ".png"
                if "jpeg" in mime_type or "jpg" in mime_type:
                    ext = ".jpg"
                elif "webp" in mime_type:
                    ext = ".webp"

                # Save to temp file
                with tempfile.NamedTemporaryFile(suffix=ext, delete=False) as tmp:
                    if isinstance(image_data, str):
                        tmp.write(base64.b64decode(image_data))
                    else:
                        tmp.write(image_data)
                    temp_image_path = tmp.name
                break

        if not temp_image_path:
            print("Error: No image was generated in the response.")
            print("Response text:", response.text if hasattr(response, 'text') else "No text")
            sys.exit(1)

        print(f"Image generated, resizing to {width}x{height}...")

        # Use ImageMagick to resize/crop to exact dimensions
        # First resize to cover the target area, then crop to exact size
        magick_cmd = [
            "magick",
            temp_image_path,
            "-resize", f"{width}x{height}^",  # Resize to cover (^ means fill)
            "-gravity", "center",
            "-extent", f"{width}x{height}",   # Crop to exact size
            "-quality", "90",
            output_path
        ]

        result = subprocess.run(magick_cmd, capture_output=True, text=True)

        if result.returncode != 0:
            print(f"ImageMagick error: {result.stderr}")
            # Try with 'convert' as fallback
            magick_cmd[0] = "convert"
            result = subprocess.run(magick_cmd, capture_output=True, text=True)
            if result.returncode != 0:
                print(f"ImageMagick fallback error: {result.stderr}")
                sys.exit(1)

        # Clean up temp file
        os.unlink(temp_image_path)

        print(f"Image saved to: {output_path}")
        return output_path

    except Exception as e:
        print(f"Error generating image: {e}")
        sys.exit(1)


def main():
    parser = argparse.ArgumentParser(
        description="Generate images using Gemini API and resize with ImageMagick",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
    python generate_image.py "berry pie on wooden table" --width 800 --height 600
    python generate_image.py "farmstand with fresh pies" -w 1200 -h 800 -o farmstand.jpg
    python generate_image.py "berry pie" -w 600 -h 600 --reference ref1.jpg ref2.jpg

Environment:
    GEMINI_API_KEY    Your Gemini API key (required)
                      Get one at: https://aistudio.google.com/apikey
        """
    )

    parser.add_argument("prompt", help="Text prompt describing the image to generate")
    parser.add_argument("-w", "--width", type=int, required=True, help="Output image width in pixels")
    parser.add_argument("-H", "--height", type=int, required=True, help="Output image height in pixels")
    parser.add_argument("-o", "--output", default="generated_image.jpg", help="Output file path (default: generated_image.jpg)")
    parser.add_argument("-m", "--model", default="gemini-2.5-flash-image",
                        choices=["gemini-2.5-flash-image", "gemini-2.5-pro-image-preview"],
                        help="Gemini model to use (default: gemini-2.5-flash-image)")
    parser.add_argument("-r", "--reference", nargs="+",
                        help="Reference image(s) for style guidance")

    args = parser.parse_args()

    # Validate dimensions
    if args.width <= 0 or args.height <= 0:
        print("Error: Width and height must be positive integers")
        sys.exit(1)

    generate_image(args.prompt, args.width, args.height, args.output, args.model, args.reference)


if __name__ == "__main__":
    main()
