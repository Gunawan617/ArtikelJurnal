#!/bin/bash

# Quick Meta Data Checker for Google Scholar
# Usage: ./check-metadata.sh [URL]

URL="${1:-http://127.0.0.1:8000/artikel/penerapan-machine-learning-dalam-prediksi-penyakit-diabetes}"

echo "🔍 Checking Meta Data for Google Scholar..."
echo "URL: $URL"
echo ""

# Check if URL is accessible
if ! curl -s -f "$URL" > /dev/null; then
    echo "❌ Error: Cannot access URL"
    echo "   Make sure the server is running: php artisan serve"
    exit 1
fi

echo "📋 Google Scholar Meta Tags:"
CITATION_COUNT=$(curl -s "$URL" | grep -c "citation_")
echo "  Found $CITATION_COUNT citation tags"
if [ "$CITATION_COUNT" -ge 8 ]; then
    echo "  ✅ PASS (minimum 8 required)"
else
    echo "  ❌ FAIL (found $CITATION_COUNT, need at least 8)"
fi

echo ""
echo "📋 Dublin Core Meta Tags:"
DC_COUNT=$(curl -s "$URL" | grep -c 'name="DC\.')
echo "  Found $DC_COUNT DC tags"
if [ "$DC_COUNT" -ge 5 ]; then
    echo "  ✅ PASS"
else
    echo "  ⚠️  WARNING (found $DC_COUNT, recommended at least 5)"
fi

echo ""
echo "📋 Open Graph Meta Tags:"
OG_COUNT=$(curl -s "$URL" | grep -c 'property="og:')
echo "  Found $OG_COUNT OG tags"
if [ "$OG_COUNT" -ge 4 ]; then
    echo "  ✅ PASS"
else
    echo "  ⚠️  WARNING (found $OG_COUNT, recommended at least 4)"
fi

echo ""
echo "📋 Schema.org JSON-LD:"
JSONLD_COUNT=$(curl -s "$URL" | grep -c "application/ld+json")
echo "  Found $JSONLD_COUNT JSON-LD script"
if [ "$JSONLD_COUNT" -ge 1 ]; then
    echo "  ✅ PASS"
else
    echo "  ❌ FAIL (JSON-LD not found)"
fi

echo ""
echo "📝 Detailed Citation Tags:"
curl -s "$URL" | grep "citation_" | sed 's/^[[:space:]]*/  /' | head -10

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
if [ "$CITATION_COUNT" -ge 8 ] && [ "$JSONLD_COUNT" -ge 1 ]; then
    echo "✅ Meta Data Check PASSED!"
    echo "   Your website is ready for Google Scholar indexing"
else
    echo "❌ Meta Data Check FAILED!"
    echo "   Please fix the issues above"
fi
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
