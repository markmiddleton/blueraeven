#!/bin/bash
#
# Sync uploads folder from local to WPEngine production
# Does NOT delete files on remote - only adds/updates
#

# WPEngine SSH details
WPENGINE_USER="blueraeven"
WPENGINE_HOST="blueraeven.ssh.wpengine.net"
REMOTE_PATH="/sites/blueraeven/wp-content/uploads/"

# Local uploads path
LOCAL_PATH="/Users/markmiddleton/Sites/blueraevenfarmstand/wp-content/uploads/"

echo "Syncing uploads to WPEngine..."
echo "From: $LOCAL_PATH"
echo "To:   $WPENGINE_USER@$WPENGINE_HOST:$REMOTE_PATH"
echo ""

# Dry run first to show what would be transferred
echo "=== DRY RUN (showing what would be synced) ==="
rsync -avz --dry-run \
    "$LOCAL_PATH" \
    "$WPENGINE_USER@$WPENGINE_HOST:$REMOTE_PATH"

echo ""
read -p "Proceed with sync? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "=== SYNCING ==="
    rsync -avz --progress \
        "$LOCAL_PATH" \
        "$WPENGINE_USER@$WPENGINE_HOST:$REMOTE_PATH"
    echo ""
    echo "Sync complete!"
else
    echo "Sync cancelled."
fi
