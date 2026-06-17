# TechNews - Modern News Feed Website

A sleek, responsive, and modern static news aggregation website powered by NewsAPI.org.

## 🎨 Features

### User Interface
- **Modern Tech-Inspired Design**: Gradient backgrounds, smooth animations, and a contemporary color scheme
- **Responsive Layout**: Fully responsive design that works seamlessly on desktop, tablet, and mobile devices
- **Sticky Navigation**: Always-accessible header with smooth scrolling
- **Hero Section**: Eye-catching introduction banner
- **Grid-Based Article Cards**: Clean, organized article display with hover effects

### Functionality
- **Real-Time News Feed**: Fetches articles from NewsAPI.org
- **Category Filtering**: Browse news by categories:
  - All News (General)
  - Technology
  - Business
  - Science
  - Health
- **Search Functionality**: Search for specific topics across all available news
- **Loading States**: Visual feedback with animated loading spinner
- **Error Handling**: Comprehensive error messages for network issues and API errors
- **Auto-Refresh**: Articles automatically update every 5 minutes

### Article Cards Include
- Article image with fallback
- Source attribution
- Article title and description
- Publication date
- Author information
- Direct link to full article

## 🚀 Getting Started

### Requirements
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Internet connection
- No backend server required!

### Installation

1. **Download all files** to a single directory:
   - `index.html`
   - `style.css`
   - `script.js`

2. **Open in browser**: Simply double-click `index.html` or open it through your web server

3. **That's it!** The website is ready to use

### Using with XAMPP
If using XAMPP (as indicated by the file location):
1. Place files in `c:\xampp\htdocs\Man\`
2. Start Apache server
3. Navigate to `http://localhost/Man/index.html`

## 🎯 How to Use

### Browsing Articles
1. **View Latest News**: Homepage automatically loads the latest general news articles
2. **Filter by Category**: Click any category button in the navigation bar to filter articles
3. **Active Indicator**: The active category is highlighted with a blue underline

### Searching
1. **Enter Search Term**: Type your search query in the search box
2. **Press Enter or Click Search**: Submit your search
3. **View Results**: Articles matching your search appear instantly
4. **Return to Categories**: Click any category to go back to category view

### Reading Articles
1. **Hover Over Cards**: Cards show a smooth lift animation on hover
2. **Click "Read More"**: Opens the full article in a new tab on the source website
3. **View Article Info**: Check the publication date and source at the bottom of each card

## 🔧 API Configuration

The website uses NewsAPI.org's free tier:

```javascript
API_KEY = 'baad8d28a6f14fd29fd2a2aa94cff52b'
```

### API Limits
- **Free Tier**: 100 requests per day
- **Rate Limit**: Approximately 50 requests per 12 hours
- **Response Time**: Typically 100-500ms per request

**Note**: For production use, consider:
- Using a backend proxy server to hide the API key
- Caching articles to reduce API calls
- Upgrading to a paid NewsAPI plan for higher limits

## 🐛 Bug Fixes Applied

### Critical Fixes
1. ✅ **XSS Prevention**: HTML escaping for all dynamic content
2. ✅ **Image Error Handling**: SVG fallbacks for failed image loads
3. ✅ **Input Validation**: Null checks for all API responses
4. ✅ **Date Parsing**: Safe date handling with try-catch
5. ✅ **URL Validation**: Verify image URLs before loading
6. ✅ **Error Recovery**: Graceful handling of API failures
7. ✅ **Accessibility**: Focus states and keyboard navigation

### User Experience Fixes
1. ✅ **Empty Search Validation**: Prevents unnecessary API calls
2. ✅ **Text Truncation**: Prevents layout breaking from long text
3. ✅ **Active Navigation State**: Proper highlighting on page load
4. ✅ **Mobile Responsiveness**: All elements adapt to screen size
5. ✅ **Network Status**: Detects offline and provides feedback

## 📱 Responsive Breakpoints

| Screen Size | Layout |
|-------------|--------|
| Desktop (1200px+) | 3-column grid |
| Tablet (768px-1199px) | 2-column grid |
| Mobile (480px-767px) | 1-column layout |
| Small Mobile (<480px) | Adjusted typography |

## 🎨 Color Scheme

| Element | Color | Use |
|---------|-------|-----|
| Primary | `#0066ff` | Links, buttons |
| Secondary | `#00d4ff` | Accents, highlights |
| Dark Background | `#0a0e27` | Main background |
| Card Background | `#1a1f3a` | Article cards |
| Text Primary | `#ffffff` | Main text |
| Text Secondary | `#a0aec0` | Metadata |
| Accent | `#ffd700` | Special elements |

## 🔒 Security Notes

### Current Implementation
- All API calls use HTTPS
- Content Security Policy recommended for production
- HTML escaping prevents XSS attacks
- No sensitive data stored locally

### Production Recommendations
1. **Use a Backend Proxy**: Hide API key from client-side code
2. **Implement CORS**: Control access to your API endpoint
3. **Add Rate Limiting**: Prevent abuse on your backend
4. **Cache Responses**: Reduce API calls and improve performance
5. **Use Environment Variables**: Never hardcode API keys

## ⚡ Performance

### Optimizations Implemented
- Hardware-accelerated CSS transforms
- Efficient event delegation
- Minimal reflows and repaints
- Lazy-loaded images
- Optimized animations with requestAnimationFrame

### Load Times (Typical)
- Initial Page Load: <1 second
- Article Load: 1-3 seconds (depends on network and API)
- Image Load: <2 seconds per image

## 🌐 Browser Compatibility

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| Mobile Chrome | Latest | ✅ Full |
| iOS Safari | 14+ | ✅ Full |

## 📚 Code Structure

### HTML (`index.html`)
- Semantic HTML5 structure
- Accessibility-focused markup
- Dynamic container for articles
- Error and loading state elements

### CSS (`style.css`)
- CSS Grid for responsive layout
- Gradient backgrounds and overlays
- Smooth transitions and animations
- Mobile-first responsive design
- CSS custom properties (variables)

### JavaScript (`script.js`)
- Async/await for API calls
- Event delegation for navigation
- DOM manipulation with vanilla JS
- Error handling and recovery
- Utility functions for validation

## 🎓 Learning Resources

### Technologies Used
- **HTML5**: Semantic markup
- **CSS3**: Grid, Flexbox, Gradients, Animations
- **JavaScript (ES6+)**: Async/await, Template literals, Arrow functions
- **NewsAPI.org**: Free news aggregation API
- **Font Awesome**: Icon library

### External Resources
- [NewsAPI.org Documentation](https://newsapi.org/docs)
- [MDN Web Docs](https://developer.mozilla.org/)
- [Font Awesome Icons](https://fontawesome.com/)

## 📝 Troubleshooting

### Articles Not Loading
1. Check your internet connection
2. Verify API key is valid
3. Check if API daily limit is exceeded
4. Try refreshing the page (Ctrl+F5)

### Images Not Displaying
- SVG fallback should appear
- Check browser console for errors
- Verify network access to image URLs

### Search Not Working
1. Make sure search term is not empty
2. Check if API daily limit is exceeded
3. Verify network connection

### Responsive Design Issues
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh page (Ctrl+F5)
3. Check browser zoom level (should be 100%)

## 💡 Future Enhancements

Potential features to add:
- [ ] Dark/Light mode toggle
- [ ] Save favorite articles
- [ ] Share articles to social media
- [ ] Article bookmarking system
- [ ] Advanced filtering options
- [ ] Infinite scroll pagination
- [ ] Backend API proxy server
- [ ] Progressive Web App (PWA) support
- [ ] Service Worker for offline support
- [ ] Backend caching layer

## 📄 License

This project uses:
- NewsAPI.org (check their terms of service)
- Font Awesome (free license)
- Free and open-source code

## 📞 Support

For issues with:
- **NewsAPI**: Visit [newsapi.org support](https://newsapi.org/support)
- **Font Awesome**: Check [fontawesome.com](https://fontawesome.com/)
- **Code**: Review the comments in the source files

## ✨ Version History

### v1.0.0 (Current)
- ✅ Initial release
- ✅ All core features implemented
- ✅ Comprehensive bug fixes
- ✅ Full responsive design
- ✅ Error handling and recovery

---

**Enjoy reading the latest news with TechNews! 🚀**
