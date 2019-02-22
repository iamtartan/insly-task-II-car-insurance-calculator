<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Insly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="https://bootswatch.com/4/united/bootstrap.css" media="screen">
    <link rel="stylesheet" href="https://bootswatch.com/_assets/css/custom.min.css">

  </head>
  <body>
    <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
      <div class="container">
        <a href="/" class="navbar-brand">Insly</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">

          <ul class="nav navbar-nav ml-auto">
            <li class="nav-item text-light">
              Car Insurance Calculator
            </li>
          </ul>

        </div>
      </div>
    </div>


    <div class="container">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-md-12">
            <h1 class="mb-5">Car Insurance Calculator</h1>
            <div class="bs-component">
              <div id="global_error" class="alert alert-dismissible alert-info">
                Please fill the form below and click on the calculate button.
              </div>
            </div>
          </div>
        </div>
      </div>

        <!-- Forms
        ================================================== -->

        <div class="row">
          <div class="col-lg-4">
            <div class="bs-component">
              <form id="insurance_form" action="/calculator" method="post">
                <fieldset>

                  <div class="form-group">
                    <label class="control-label" for="car_value">Estimated Car value (in Euro)</label>
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">€</span>
                        </div>
                        <input id="car_value" type="number" class="form-control form-control-lg" name="car_value" placeholder="10,000">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Tax Percentage</label>
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">%</span>
                        </div>
                        <input id="tax" name="tax" type="text" class="form-control form-control-lg numeric-only" placeholder="10">
                      </div>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="exampleSelect1">Number of installment</label>
                    <select id="installments" name="installments" class="form-control form-control-lg" id="exampleSelect1">
                        <?php for($i=1; $i<=$maxInstallments; $i++):?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php endfor;?>
                    </select>
                  </div>

                  <button id="calculate_insurance" type="submit" class="btn btn-lg btn-info">Calculate</button>
                    <img id="ajax-indicator" class="d-none" src="images/loading.gif" />
                </fieldset>
              </form>
            </div>
          </div>

          <div class="col-lg-8">

              <div class="bs-component">
                  <img alt="" class="img-fluid" src="images/car-insurance.jpg" />
              </div>

          </div>
        </div>
        </div>


    <div class="container my-5">
        <div class="row">
            <div class="col" id="installment_table"></div>
        </div>
    </div>

    <div class="container">

        <div class="alert alert-dismissible alert-success">
            <h4>Installing</h4>
            <ul>
                <li>For running <b>basic</b> branch just copy <b>config-sample.php</b> file to <b>config.php</b> and run index.php file in public folder.</li>
            </ul>
        </div>

        <div class="alert alert-dismissible alert-info">
            <h4>Rules</h4>
            <ul>
                <li>If the amount is <b>not divisible</b> by installments, the <b>first installment</b> values will be different from other installments.</li>
                <li>Base price of policy is <b>11%</b> from entered car value, except every Friday 15-20 o’clock (user time) when it is <b>13%</b>. More rules can be added in config file.</li>
                <li>I've added <b>1 second delay</b> to response time just for better experience in <b>demo</b>.</li>
            </ul>
        </div>

        <div class="alert alert-dismissible alert-primary">
            <h4>Branch details</h4>
            <ul>
                <li>The project developed with <b>vanilla</b> PHP and Javascript without using any framework, template engine or third-party package.</li>
                <li>This project has been developed in two branches <b>basic</b> and <b>modern</b>.</li>
                <li>I haven't used php <b>composer</b>, <b>DI</b> or any other modern concepts in <b>basic</b> branch.</li>
                <li>Modern concepts and structures are used just in the <b>modern</b> branch.</li>
                <li>Basic branch does not contain <b>phpunit</b> test</li>
            </ul>
        </div>


      <footer id="footer">
        <div class="row">
          <div class="col-lg-12">

            <ul class="list-unstyled">
              <li class="float-lg-right"><a href="#top">Back to top</a></li>
              <li><a href="https://insly.com">Insly</a></li>
              <li><a href="https://twitter.com/a6oozar">Twitter</a></li>
              <li><a href="https://github.com/iamtartan/insly-task-II-car-insurance-calculator">Git Repository</a></li>
            </ul>
            <p>Made by <a href="http://tartan.us.to/">Aboozar Ghaffari</a>.</p>
            <p>Code released under the <a href="https://github.com/thomaspark/bootswatch/blob/master/LICENSE">MIT License</a>.</p>
            <p>Based on <a href="https://getbootstrap.com/" rel="nofollow">Bootstrap</a>. Icons from <a href="http://fontawesome.io/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="https://fonts.google.com/" rel="nofollow">Google</a>.</p>

          </div>
        </div>

      </footer>

    </div>

    <script type="text/javascript" src="js/scripts.js"></script>
  </body>

</html>