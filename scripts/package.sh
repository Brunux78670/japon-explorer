#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
mkdir -p dist
out="dist/site-japon-laravel-source.zip"
rm -f "$out"
zip -rq "$out" . \
  -x ".git" ".git/*" ".worktrees/*" "vendor/*" "node_modules/*" ".env" \
     "dist/*" "storage/logs/*" "storage/framework/cache/*" "storage/framework/sessions/*" "storage/framework/views/*"
echo "$out"
