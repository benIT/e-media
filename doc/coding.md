## Coding

## Translation

Translations are managed using symfony domains. Translations are available in [this folder](../app/Resources/translations).

### JS translations

- JS translations are dumped from symfony using this command:

        php bin/console bazinga:js-translation:dump web/assets/js --format=js --merge-domains
    
- Then minified thanks to grunt, see [Gruntfile.js](../Gruntfile.js):

- Finally dynamically included (for the required current locale):    
        
            
            <script src="{{ asset('assets/dist/js/translations/'~locale~'.min.js') }}"></script>
    