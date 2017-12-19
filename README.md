# Library agnostic to valid Google reCaptcha in PHP projects

Valid g-ReCaptcha 2.0 in your back-end project

You can view details to back-end integration in [docs][link-back]

[link-back]: https://developers.google.com/recaptcha/docs/verify

Use example
--
```php
  $params = [
       'url' => 'https://www.google.com/recaptcha/api/siteverify',
       'secret' => 'YOUR_SECRET_FROM_RECAPTCHA',
       'reCaptcha' => $_POST['g-recaptcha-response']
       // Optional parameters
       'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36'
       'ipAddress' => '127.0.0.1',
  ];

  try {
      $captcha = new ReCaptcha2($params);
      $request = $captcha->request();

      if ($request->isValid()) {
          // Dont is bot, ready!
      } else {
          $error = $captcha->getErrors();
      }
  } catch (Exception $exception) {
      $error = $exception->getMessage();
  }
```

Side Client
--
You can view details to front-end integration in [docs][link-front]

[link-front]: https://developers.google.com/recaptcha/docs/invisible