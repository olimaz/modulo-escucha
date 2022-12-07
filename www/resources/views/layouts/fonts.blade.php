<style>

  /* source-sans-pro-300 - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: normal;
    font-weight: 300;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot') }}'); /* IE9 Compat Modes */
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Light'), local('SourceSansPro-Light'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-300italic - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: italic;
    font-weight: 300;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Light Italic'), local('SourceSansPro-LightItalic'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-300italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-regular - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: normal;
    font-weight: 400;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-regular.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-italic - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: italic;
    font-weight: 400;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Italic'), local('SourceSansPro-Italic'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-600 - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: normal;
    font-weight: 600;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro SemiBold'), local('SourceSansPro-SemiBold'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-600italic - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: italic;
    font-weight: 600;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro SemiBold Italic'), local('SourceSansPro-SemiBoldItalic'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-600italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-700 - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: normal;
    font-weight: 700;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }
  /* source-sans-pro-700italic - latin-ext_latin */
  @font-face {
    font-family: 'Source Sans Pro';
    font-style: italic;
    font-weight: 700;
    src: url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.eot') }}'); /* IE9 Compat Modes */
    src: local('Source Sans Pro Bold Italic'), local('SourceSansPro-BoldItalic'),
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.woff') }}') format('woff'), /* Modern Browsers */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
    url('{{ url('assets/fonts/source-sans-pro-v11-latin-ext_latin-700italic.svg#SourceSansPro') }}') format('svg'); /* Legacy iOS */
  }

</style>