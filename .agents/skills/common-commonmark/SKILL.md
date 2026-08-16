---
name: common-commonmark
description: Ensures all Markdown output conforms to the CommonMark specification (https://spec.commonmark.org).
---

# common-commonmark

Write and validate Markdown that conforms to the CommonMark specification (version 0.31.2).

## When to use

Use this skill when:

- Writing or generating any Markdown content (documentation, READMEs, changelogs, comments)
- Reviewing Markdown files for correctness
- Encountering ambiguous Markdown syntax and needing a definitive rule
- Creating templates or snippets that include Markdown

## Instructions

### 1. Use ATX headings exclusively

Use `#` style headings (ATX). Do not use setext (underline) headings.

- Always include exactly one space between the `#` characters and the heading text.
- Never exceed six `#` characters.
- Do not use closing `#` sequences.

```markdown
# Heading 1
## Heading 2
### Heading 3
```

### 2. Separate blocks with blank lines

Insert a blank line before and after:

- Headings
- Code blocks (fenced or indented)
- Block quotes
- Lists
- Thematic breaks

This avoids ambiguous parsing where a block element could be interpreted as a continuation of the preceding paragraph.

### 3. Use fenced code blocks with an info string

Always use backtick fences (`` ``` ``) rather than indented code blocks. Specify a language identifier after the opening fence.

````markdown
```javascript
const x = 1;
```
````

- Use at least three backticks.
- Do not mix backtick and tilde fences within the same document.
- Never put backticks in the info string of a backtick fence.

### 4. Format lists consistently

- Use `-` as the bullet list marker. Do not mix `-`, `+`, and `*` within one list.
- Use `1.` for ordered list markers (not `1)`).
- Include exactly one space after the list marker.
- Indent continuation content to align with the first non-space character after the marker.

```markdown
- First item
- Second item with a continuation paragraph

  This paragraph belongs to the second item.
```

### 5. Use thematic breaks correctly

Use `---` on its own line (three hyphens) for thematic breaks. Do not use `***` or `___` to avoid confusion with emphasis markers.

### 6. Emphasis and strong emphasis

- Use `*single asterisks*` for emphasis.
- Use `**double asterisks**` for strong emphasis.
- Do not use underscores (`_`) for emphasis — they do not work inside words.

### 7. Links and images

- Use inline links when the URL is short: `[text](url "optional title")`
- Use reference links for repeated or long URLs:

  ```markdown
  [text][ref]

  [ref]: /url "title"
  ```

- Do not put a space between the link text and the parenthesis or bracket.

### 8. Code spans

- Use backticks for inline code: `` `code` ``.
- If the code contains backticks, use double backticks with spaces: ``` `` code`with`backticks `` ```.

### 9. Hard line breaks

Use a backslash at the end of a line (`\`) for a hard line break. Do not rely on trailing spaces — they are invisible and easily stripped.

### 10. Escape special characters when needed

Use backslash escapes for literal special characters that would otherwise trigger Markdown syntax:

```text
\* \- \# \[ \] \( \) \` \> \!
```

### 11. Validate ambiguous constructs

When in doubt about how a construct will be parsed, apply these CommonMark precedence rules:

1. Block structure takes precedence over inline structure.
2. Code spans, autolinks, and raw HTML bind more tightly than emphasis.
3. Link text grouping takes precedence over emphasis.

If a construct could be parsed in multiple ways, restructure it to be unambiguous — add blank lines, use explicit fencing, or add escapes.

## References

- [CommonMark Spec 0.31.2](https://spec.commonmark.org/0.31.2/)
- [CommonMark interactive tutorial](https://commonmark.org/help/)
