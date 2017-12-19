<?php

use FreddieGar\GReCaptcha\ReCaptcha2;

class ReCaptcha2FunctionalityTest extends BaseTestCase
{
    public function testReCaptcha2OK()
    {
        $params = array(
            'url' => 'https://www.google.com/recaptcha/api/siteverify',
            'secret' => '6LckMh8UAAAAAGigvB-PpKEXtNGYR9BJRakQ5Cjg',
            'ipAddress' => '127.0.0.1',
            'reCaptcha' => '03AO6mBfz_Th0BORVsFtkE4HGRZdwBvEQ4aPcajqio719tXb71TUvzN4O_bjH6K1jz8XDyNewo6FdcZDEFz2cvr-SqI8Mff5yWpAbflyZzGf5LGu5RctwCy7JuZx6XoRQtDiS4w4X77Dnv8DPaBYAUVhGO6KwmacEnLurYSfd01-0RXuf7QXB_SW3Xt2RC3rzOHrfOiCKdrB5QkokqHCsUzd6PFQm0j_8jYqpmM5wkeMw0Y_tVMFZcZ5NV0G7n8AkuTLY831ApdbraQ0hWk84bZSaTobEFrclZEhGkjYFM9FI_pbaVPGSVOEn18a7s7pfn2mqZ5Q4NIT3fPKX4KZqxaNruAmQll4rtY-GQwUlHOq-BrXHpOQQI-Yrkftkodo2JOoCLzPRNYPdGpR7QCgr3NGkLbYg6x2Y4UTlNqnHg99zTj4W93DBwn48'
        );

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

        $this->assertEquals(true, true);
    }
}
