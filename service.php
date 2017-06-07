 <?php 
        //Data, connection, auth
        $msisdnForm = $_POST['msisdn']; // request data from the form
        $amountForm = $_POST['amount']; // request data from the form
        //$msisdnForm = $_POST['msisdn']; // request data from the form
        $soapUrl = "http://10.138.84.138:8002/ThirdPartyGateway_1_0?p=Impala2tigowalletpayment"; // asmx URL of WSDL
        // $soapUser = "username";  //  username
        // $soapPassword = "password"; // password
        $MSISDN = "250722123270";
        $Password = "Tigo1234";
        $Billercode = "4003";
        $Username = "250721000115";


        // xml post structure

		        $xml_post_string = '<TCSRequest>
									<UserName>'.$Username.'</UserName>
									<Password>'.$Password.'</Password>
									<Function name="WALLETPAYMENT">
									<msisdn>'.$MSISDN.'</msisdn>
									<amount>10</amount>
									<transactionId>1194</transactionId>
									<bankCode>'.$Billercode.'</bankCode>
									</Function>
									</TCSRequest>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
            curl_close($ch);

            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);

            // convertingc to XML
            $parser = simplexml_load_string($response2);
            // user $parser to get your data out of XML response and to display it.
            echo $response1;
            //echo $parser;
    ?>
