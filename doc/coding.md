# Coding

## Semantic versioning

Versioning is done according to [semantic versioning](http://semver.org/). Thus:

        Given a version number MAJOR.MINOR.PATCH, increment the:
        
        MAJOR version when you make incompatible API changes,
        MINOR version when you add functionality in a backwards-compatible manner, and
        PATCH version when you make backwards-compatible bug fixes.
        Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.


## Dependencies

### PHP dependencies and composer

Do not use too much permissive dependencies and [take care when writing dependencies](https://getcomposer.org/doc/articles/versions.md#writing-version-constraints). Thus:  

        Tilde Version Range (~)#
        
        The ~ operator is best explained by example: ~1.2 is equivalent to >=1.2 <2.0.0, while ~1.2.3 is equivalent to >=1.2.3 <1.3.0.
        
        Caret Version Range (^)#
        
        The ^ operator behaves very similarly but it sticks closer to semantic versioning, and will always allow non-breaking updates. For example ^1.2.3 is equivalent to >=1.2.3 <2.0.0 as none of the releases until 2.0 should break backwards compatibility.
        
## Translation

Translations are managed using symfony domains.

### PHP translations

Translations are available in [this folder](../app/Resources/translations).

### JS translations

- JS translations are dumped from symfony using this command:

        php bin/console bazinga:js-translation:dump web/assets/js --format=js --merge-domains
    
- Then minified thanks to grunt, see [Gruntfile.js](../Gruntfile.js):

- Finally dynamically included (for the required current locale):    
        
            
            <script src="{{ asset('assets/dist/js/translations/'~locale~'.min.js') }}"></script>


## Coding style

### PHP    

     php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --rules=@Symfony ./
    
    