# Luna Intro Video Directory

This directory contains the introduction video for Luna AI chatbot.

## Required Files

Place your Luna introduction video files here with the following names:

- `luna-intro.mp4` - Primary video file (MP4 format, recommended)
- `luna-intro.webm` - Alternative video file (WebM format, for better browser compatibility)

## Video Specifications

### Recommended Settings:
- **Duration**: 5-10 seconds (keep it short and engaging)
- **Aspect Ratio**: 16:9 (landscape) or 1:1 (square)
- **Resolution**:
  - 1920x1080 (Full HD) for high quality
  - 1280x720 (HD) for smaller file size
- **File Size**: < 5MB (for fast loading)
- **Frame Rate**: 30fps or 60fps
- **Audio**: Yes (with speech/background music)
- **Codec**: H.264 (MP4) or VP9 (WebM)

### Video Content Example:
```
"Hi, I'm Luna, your AI beauty expert assistant.
I'm here to help you learn about Lunaray Beauty Factory.
What would you like to know?"
```

## How It Works

1. **First Visit**: When a user clicks the Luna avatar for the first time, the video modal appears
2. **Autoplay**: Video plays automatically (muted by default)
3. **Controls**:
   - Unmute button (to hear audio)
   - Skip button (appears after 2 seconds)
   - Close button (top right corner)
4. **After Video**: Chat panel opens automatically
5. **Subsequent Visits**: Video is skipped, chat opens directly (tracked via localStorage)

## Testing Without Video

If you don't have the video files yet:
1. The component will still work (shows "Loading..." overlay)
2. Users can click "Skip Intro" after 2 seconds
3. Chat will open normally

## Browser Compatibility

- MP4 (H.264): Supported by all modern browsers
- WebM (VP9): Better quality, supported by Chrome, Firefox, Edge

## Converting Video Files

### Using FFmpeg:
```bash
# Convert to MP4 (H.264)
ffmpeg -i input.mov -c:v libx264 -crf 23 -preset medium -c:a aac -b:a 128k luna-intro.mp4

# Convert to WebM (VP9)
ffmpeg -i input.mov -c:v libvpx-vp9 -crf 30 -b:v 0 -c:a libopus luna-intro.webm

# Reduce file size (compress)
ffmpeg -i luna-intro.mp4 -vf scale=1280:720 -c:v libx264 -crf 28 luna-intro-compressed.mp4
```

## Updating the Video

To update the video:
1. Replace `luna-intro.mp4` and `luna-intro.webm` in this directory
2. Clear browser cache or use incognito mode to test
3. To reset "watched" status: Clear localStorage key `luna_intro_watched`

## Console Commands to Test

### Reset Video Introduction (in browser console):
```javascript
// Clear the "watched" flag
localStorage.removeItem('luna_intro_watched');
// Reload page
location.reload();
```

### Check Video Status:
```javascript
// Check if user has watched intro
console.log(localStorage.getItem('luna_intro_watched'));
// Output: 'true' if watched, null if not
```

---

**Note**: Make sure video files are optimized for web to ensure fast loading times!
