#!/usr/bin/env bash
set -euo pipefail

KEY="${KEY:-$HOME/Downloads/cl.pem}"
HOST="${HOST:-ubuntu@51.21.110.131}"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"

chmod 400 "$KEY"

echo "Syncing vendor (if missing on server)..."
rsync -avz --exclude-from="$ROOT/deploy/rsync-exclude.txt" \
    -e "ssh -i $KEY -o ServerAliveInterval=15" \
    "$ROOT/vendor/" "$HOST:/var/www/convertlane/vendor/"

echo "Running finish script on server..."
ssh -i "$KEY" -o ServerAliveInterval=15 "$HOST" 'bash -s' < "$ROOT/deploy/finish-on-server.sh"

echo ""
echo "Public check: curl -I http://51.21.110.131/"
