# Release v1.0.0

Release date: 2025-08-24

## Summary

Initial release of `laravel-responses`.

## Changes

- Standardize JSON payload format: status, code, message, data
- Add response helpers and response factory macros
- Add configuration file `config/laravel-responses.php`
- Add PHPUnit tests and basic test coverage
- Improve PHPDocBlocks and enum documentation
- Ensure package is usable without full Laravel container during tests

---

How to publish this release on GitHub:

1. Using the GitHub web UI:
   - Go to the repository Releases page: https://github.com/eborio/laravel-responses/releases
   - Click "Draft a new release"
   - Tag version: `v1.0.0`
   - Release title: `v1.0.0`
   - Paste the contents of this file into the release body
   - Click "Publish release"

2. Using GitHub CLI (if available locally):
   - `gh release create v1.0.0 --title "v1.0.0" --notes-file RELEASE_BODY.md`

3. Using the GitHub API (curl), provide a personal access token with `repo` scope:

   ```bash
   curl -X POST \
     -H "Authorization: token YOUR_TOKEN" \
     -H "Accept: application/vnd.github+json" \
     https://api.github.com/repos/eborio/laravel-responses/releases \
     -d '{"tag_name":"v1.0.0","name":"v1.0.0","body":"'"$(awk 'BEGIN{ORS="\\n"} {gsub(/"/,"\"",$0); printf "%s\\n", $0}' RELEASE_BODY.md)"'"}'
   ```

Replace `YOUR_TOKEN` with a personal access token. The curl command is provided as an example and may require escaping adjustments in zsh.
