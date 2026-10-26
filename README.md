# Webnix Studio (PHP)
Local run: `php -S localhost:8000` (is folder me) ya hosting ke public_html me upload karo (PHP 8+).
- config/config.php   -> text, contact, services
- assets/css/theme.css -> colors/fonts
- sections/*.php      -> page sections | includes/ -> header/footer/helpers
- api/contact.php     -> form handler; leads storage/leads.log me + email

## Update notes
- Hero: left text now rides the porthole zoom and exits to the left (no fade). Stars canvas sits behind the earth (assets/img/earth.webp now has transparent space).
- Contact: blue is a soft gradient "shadow" rising over a clean earth (sections/contact.php + .contact in main.css). sky.webp is only a faint cloud texture at the bottom.
- Form: services are grouped chips (config/config.php -> service_groups), plus budget, company, project details. API validates services against the config list.
