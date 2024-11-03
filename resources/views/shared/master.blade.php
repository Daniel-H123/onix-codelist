<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <style type="text/css">
  .navbar-default .navbar-form {width: 50%;}
  .navbar-form .form-group {display: block !important;}
  .navbar-default .navbar-collapse {padding-right: 0;}
  </style>

  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/flatly/bootstrap.css" rel="stylesheet">
  <link href="{{ url('algolia-autocomplete.css') }}" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">onix-codelists.io</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="{{ active_class(if_uri(['codelist']), 'active') }}"><a href="/codelist">Codelists</a></li>
              <li class="{{ active_class(if_uri(['api-docs']), 'active') }}"><a href="/api-docs">API</a></li>
              <li class="{{ active_class(if_uri(['about']), 'active') }}"><a href="/about">About</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="/search" style="width: 50%">
              <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search" name="q" id="search-input">
              </div>
            </form>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>

      <a href="https://github.com/lasselehtinen/onix-codelist">
        <img style="position: absolute; top: 0; right: 0; border: 0;" src="{{ url('/svg/github-mark-white.svg')}}" alt="Fork me on GitHub">
      </a>

      <div class="container">
        @yield('content')
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
      <script src="https://cdn.jsdelivr.net/hogan.js/3.0/hogan.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.jquery.min.js"></script>
      <script>
        var client = algoliasearch('0AX2Y3FFW8', 'ed59fb1126ff48502e68207c0488c5ba')
        var codelists = client.initIndex('codelists');
        var codes = client.initIndex('codes');
        var elements = client.initIndex('elements');

        // Mustache templating by Hogan.js (http://mustache.github.io/)
        var templateCodelist = Hogan.compile('<div class="codelist">' +
          '<div class="description">@{{{ _highlightResult.description.value }}} <small>(Codelist @{{ number }})</small></div>' +
        '</div>');

        var templateCode = Hogan.compile('<div class="code">' +
          '<div class="description">@{{{ _highlightResult.description.value }}} <small>(Codelist @{{ codelist.number }}: @{{ codelist.description }})</small></div>' +
        '</div>');

        var templateElement = Hogan.compile('<div class="code">' +
          '<div class="description">&lt;@{{{ reference_name }}}&gt; or &lt;@{{{ short_name }}}&gt; <small>(Codelist @{{ codelist.number }}: @{{ codelist.description }})</small></div>' +
        '</div>');

        $('#search-input').autocomplete({ hint: false }, [
          {
            source: $.fn.autocomplete.sources.hits(codelists, { hitsPerPage: 8 }),
            displayKey: 'description',
            templates: {
              header: '<div class="category">Codelists</div>',
              suggestion: function(hit) {
                // render the hit using Hogan.js
                return templateCodelist.render(hit);
              }
            }
          },
          {
            source: $.fn.autocomplete.sources.hits(codes, { hitsPerPage: 5 }),
            displayKey: 'description',
            templates: {
              header: '<div class="category">Codes</div>',
              suggestion: function(hit) {
                // render the hit using Hogan.js
                return templateCode.render(hit);
              }
            }
          },
          {
            source: $.fn.autocomplete.sources.hits(elements, { hitsPerPage: 5 }),
            displayKey: 'description',
            templates: {
              header: '<div class="category">Elements</div>',
              suggestion: function(hit) {
                // render the hit using Hogan.js
                return templateElement.render(hit);
              }
            }
          }
        ]).on('autocomplete:selected', function(event, suggestion, dataset) {
          window.location.href = '/codelist/' + suggestion.number;
        });
      </script>

    </body>
    </html>