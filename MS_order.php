<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multistep order form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <style>
        /*basic reset*/
        * {margin: 0; padding: 0;}


        /*form styles*/
        #msform {
            width: 400px;
            margin: 50px auto;
            position: relative;
        }
        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 8px;
            box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.2);
            padding: 20px 40px;
            margin: 0 10%;

            /*stacking fieldsets above each other*/
            position: absolute;
        }
        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }
        /*inputs*/
        #msform input, #msform textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        /*buttons*/
        #msform .action-button {
            width: 100px;
            background: #3758fb;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 1px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px;
        }

        #msform .action-button .correct{
            width: 300px;
        }

        #msform .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
        }
        /*headings*/
        .fs-title {
            font-size: 18px;
            color: #2C3E50;
            margin-bottom: 20px;
        }
        .fs-subtitle {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }
        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }
        #progressbar li {
            list-style-type: none;
            color: #737373;
            text-transform: uppercase;
            font-size: 9px;
            width: 10%;
            float: left;
            text-align:center;
            left:25%;
            position: relative;
            margin-top:15px;
        }
        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 20px;
            line-height: 20px;
            display: block;
            font-size: 10px;
            color: #737373;
            background: white;
            border-radius: 8px;
            margin: 0 auto 3px auto;
        }
        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: white;
            position: absolute;
            left: -50%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }
        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }
        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active:before,  #progressbar li.active:after{
            background: #3758fb;
            color: white;
        }

        .progressbaritems .active{
            backgroud:#3758fb;
        }



    </style>
<script  type="text/javascript" >
    var req = true;
    function nextStep(){ //wat er gebeurt als er op een knop met de class next wordt geklikt.
        
        req = true;
		var classname = ".step" + currentindex;
		$(classname).each(function() {
			if($(this).val() == ""){
				req = false;
				$("#error" + currentindex).text($(this).attr('id') + " is required.");
                return false;
			}
				
		}
		)
		if(req){
            current = $("#fieldset" + currentindex); //current wordt de div waar de next knop waar op is geklikt zich in bevindt.
			next = current.next(); //next wordt de div onder current.
			current.hide(); //maakt de huidige div onzichtbaar.
			next.show(); //maakt de vorige div onzichtbaar.
            $("#next" + currentindex).keyup("");
            $("#error" + currentindex).html("");
			currentindex ++;
			$("#listitem" + currentindex).addClass("active");
		}
    }
    
    function prevStep(){ //wat er gebeurt als er op een knop met de class next wordt geklikt.
        current = $("#fieldset" + currentindex); //current wordt de div waar de prev knop waar op is geklikt zich in bevindt.
        prev = current.prev();  //prev wordt de div boven current.
        current.hide(); //maakt de huidige div onzichtbaar.
        prev.show(); //maakt de vorige div zichtbaar.
        $("#listitem" + currentindex).removeClass("active");
        currentindex --;
    }
    
    $(document).keydown(function(e){
        if(e.keyCode==13){
                nextStep();
        }
    });
    </script>
</head>
<body background="halftone.png">

<ul id="progressbar">
    <li id="listitem1" class="progressbaritems active">Order verification</li>
    <li id="listitem2" class="progressbaritems">Address</li>
    <li id="listitem3" class="progressbaritems">Total price</li>
    <li id="listitem4" class="progressbaritems">Total price</li>
    <li id="listitem5" class="progressbaritems">Payment</li>
</ul>


<!-- TO-DO HIER: Zoek een manier om de Next te stoppen wanneer niet alle required fields ingevuld zijn -->
<form id="msform" onsubmit="return false;" method="post" action="addorder.php">
    <fieldset id="fieldset1">
        <!-- Alle values zetten op de invoer van de sidebar invoer -->
        <h2 class="fs-title">Verify your order</h2>
		<div id="error1"></div>
        <label>Product:</label>
        <input id="Product" type="text" class="reqinput step1" name="product" value=<?php if(isset($_POST['product'])){echo $_POST['product'];}?>><br><br>

        <label>Size:</label>
        <input id="Size" type="text" class="reqinput step1" name="size" value=<?php if(isset($_POST['size'])){echo $_POST['size'];}?>><br><br>

        <label>Quantity:</label>
        <input id="Quantity" type="number" class="reqinput step1" name="quantity" value=<?php if(isset($_POST['quantity'])){echo $_POST['quantity'];}?>><br><br>

        <!-- button -->
        <input type="button" id="next1" name="correct" class="correct action-button next" value="Correct">
    </fieldset>

    <fieldset id="fieldset2">
        <h2 class="fs-title" style="color: #112f55;">Your delivery address</h2>
		<div id="error2"></div>
        <label>Full name:</label>
        <input id="Full name" type="text" class="reqinput step2" name="fullname" placeholder="John Jackson"><br><br>

        <label>Name of company</label>
        <input id="Company name" type="text" class="reqinput step2" name="companyname" placeholder="Google"><br><br>

        <label>Street:</label>
        <input id="Street" type="text" class="reqinput step2" name="streetname" placeholder="Blauwstraat">

        <label>House number:</label>
        <input id="House number" type="number" class="reqinput step2" name="housenumber" placeholder="75"><br><br>

        <label>City:</label>
        <input id="City" type="text" class="reqinput step2" name="cityname" placeholder="Hong-Kong"><br><br>

        <label>Country:</label>
        <select id="Country" name="country" class="col-sm-3 step2">
            <option value="">Country...</option>
            <option value="Afganistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote D'Ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                            <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
    </select>

        <label>Postal code:</label>
        <input id="Postal code" type="text" class="reqinput step2" name="postalcode" placeholder="7862XX"><br><br>

        <label>E-mail address</label>
        <input id="E-mail address" type="email" class="reqinput step2" name="email" placeholder="john@jackson.com"><br><br>

        <!-- Buttons -->
        <input type="button" name="Previous" class="previous action-button" value="Previous" />
        <input type="button" id="next2" name="Next" class="next action-button" value="Next" />

    </fieldset>
    <fieldset id="fieldset3">
        <h2 class="fs-title" style="color: #112f55">Total price</h2>
            Delivery cost: Test delivery cost<!-- Hoe gaan we dit precies doen? Delivery cost uit een database halen?-->

        <br><br>
        <!-- Buttons -->
        <input type="button" name="Previous" class="previous action-button" value="Previous" />
<!--        <input type="button" id="next3" name="Next" class="next action-button" value="Next" />-->
        <input type="submit"  class="action-button" value="Next" />
    </fieldset>
<!--
    <fieldset>
         Payment
        <h2 class="fs-title" style="color: #112f55">Payment</h2>
        <button class="col-md-1">Check out with <img src="Paypal-Logo-Transparent-png-format-large-size.png"></button>
        <input type="submit">
</fieldset>
-->

</form>


<!-- jQuery (dit is van die site, we kunnen opzich eigen jQuery downloaden? Misschien meer opties, het is ondertussen 3.1 -->

<script src="jquery-3.1.1.js" type="text/javascript"></script>

<!-- jQuery easing plugin -->
<script type="text/javascript">
    var currentindex = 1;//
    var next, prev, current;

    $(".next").click(function(){nextStep()});
    $(".previous").click(function(){prevStep();});
</script>

</body>
</html>
