<?php 
        //Data, connection, auth
//        $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL"; // asmx URL of WSDL
        $soapUser = "username";  //  username
        $soapPassword = "password"; // password

        // xml post structure

        $xml_post_string = "<soap:Envelope xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>

<soap:Body>
<interactive_verification_start xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://openhbx.org/api/terms/1.0'>
	<individual>
		<id>
			<id>1234</id>
		</id>
		<person>
			<id>
				<id>1234</id>
			</id>
			<person_name>
				<person_surname>Edward</person_surname>
				<person_given_name>Ann</person_given_name>
			</person_name>

			<addresses>
				<address>
					<type>urn:openhbx:terms:v1:address_type#mailing</type>
					<address_line_1>087 Westerfield Plaza</address_line_1>
					<location_city_name>Seaside</location_city_name>
					<location_state_code>MD</location_state_code>
					<postal_code>13455</postal_code>
					<location_postal_extension_code>4610</location_postal_extension_code>
				</address>
				<address>
					<type>urn:openhbx:terms:v1:address_type#work</type>
					<address_line_1>087 Westerfield Plaza</address_line_1>
					<address_line_2>54 Bayside Junction</address_line_2>
					<location_city_name>Seaside</location_city_name>
					<location_state_code>MD</location_state_code>
					<postal_code>13455</postal_code>
					<location_postal_extension_code>4610</location_postal_extension_code>
				</address>

			</addresses>
			<emails>
				<email>
					<type>urn:openhbx:terms:v1:email_type#home</type>
					<email_address>alee@latz.net</email_address>
				</email>
				<email>
					<type>urn:openhbx:terms:v1:email_type#home</type>
					<email_address>cadams@edgeblab.com</email_address>
				</email>
				<email>
					<type>urn:openhbx:terms:v1:email_type#home</type>
					<email_address>rfreeman@gabtune.biz</email_address>
				</email>

			</emails>
			<phones>
				<phone>
					<type>urn:openhbx:terms:v1:phone_type#mobile</type>
					<full_phone_number>14944520450</full_phone_number>
					<is_preferred>false</is_preferred>
				</phone>
				<phone>
					<type>urn:openhbx:terms:v1:phone_type#mobile</type>
					<full_phone_number>14016906878</full_phone_number>
					<is_preferred>false</is_preferred>
				</phone>

			</phones>
		</person>
		<person_demographics>
			<sex>urn:openhbx:terms:v1:gender#male</sex>
			<birth_date>20150812</birth_date>
			<created_at>2015-08-12T16:29:20Z</created_at>

		</person_demographics>
	</individual>
</interactive_verification_start>

</soap:Body>
</soap:Envelope>

                            ";   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep/process", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
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
    ?>
