AFAQ BUILD — NETLIFY STATIC EDITION

DEPLOY:
1. Extract this ZIP.
2. Confirm index.html, netlify.toml, assets/, services/, projects/, calculators/, and contact/ are in the same top-level folder.
3. Netlify: Add new site -> Deploy manually, then drag the extracted site folder into the deploy area; OR push the extracted folder to GitHub and import the repository.
4. Build command: leave blank.
5. Publish directory: . (the folder containing index.html).
6. Test /, /services/, /projects/, /calculators/, and /contact/.

LIMITATIONS:
- This is a static rebuild based on the uploaded PHP project and existing visual assets.
- PHP admin panel and SQLite/database functionality were removed because Netlify does not execute ordinary PHP pages.
- Projects are intentionally left as "coming soon"; no completed projects or client details were invented.
- Contact form prepares a local text file only; it does not send or store inquiries.
- Calculator runs in the browser. Verify dimensions and results before relying on estimates.
- Confirm all service descriptions, contact details, logos and images with AFAQ Construction before publishing.
