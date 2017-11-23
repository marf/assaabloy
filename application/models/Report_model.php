<?php

class Report_Model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function insertReport($date, $ofo, $callNumber, $client, $interventionPlace, $techNum, $totalWHours, $totalTHours, $km, $spareCost = 0, $fix = false, $transportCost = 0)
        {
            $errors = array();
            for($i = 0; $i < 9; $i++)
                $errors[$i] = false;
            $error = "";
            if(!$this->validateDate($date))
            {
                $error = "Formato data non valido, specificare come gg/mm/YYYY (es. 12/10/2017)<br>";
                $errors[0] = true;
            }
            if(!$this->checkOfo($ofo))
            {
                $error .= "Il valore OFO deve iniziare con le ultime due cifre dell'anno corrente, deve contere '/' dopo di esse ed a cui devono seguire 5 cifre (es. 17/05389)<br>";
                $errors[1] = true;
            }
            if(!$this->checkCallNumber($callNumber))
            {
                $error .= "Il codice chiamata deve iniziare con le ultime due cifre dell'anno corrente, deve contere '/' dopo di esse ed a cui devono seguire 10 cifre (es. 17/0000005766)<br>";
                $errors[2] = true;
            }
            if(!$this->checkInt($techNum))
            {
                $error .= "Il numero di tecnici deve essere intero (es. 1)<br>";
                $errors[3] = true;
            }
            if(!$this->checkInt($totalWHours) && !$this->checkDouble($totalWHours))
            {
                $error .= "Il numero di ore di manodopera deve essere intero oppure decimale (es. 2 oppure 2.5 --> 2 ore e mezza)<br>";
                $errors[4] = true;
            }
            if(!$this->checkInt($totalTHours) && !$this->checkDouble($totalTHours))
            {
                $error .= "Il numero di ore di viaggio deve essere intero oppure decimale (es. 2 oppure 2.5 --> 2 ore e mezza)<br>";
                $errors[5] = true;
            }
            if(!$this->checkInt($km) && !$this->checkDouble($km))
            {
                $error .= "Il numero totale di Km deve essere intero oppure decimale (es. 2 oppure 2.5 --> 2 ore e mezza)<br>";
                $errors[6] = true;
            }

            /*if($fix == "0")
                $fix = false;
            else if($fix == "1")
                $fix = true;*/
            
            if(!$this->checkInt($spareCost) && !$this->checkDouble($spareCost))
            {
                $error .= "Il costo dei pezzi di ricambio deve essere intero oppure decimale (es. 200 oppure 230.20)<br>";
                $errors[7] = true;
            }
            
            if(!$this->checkInt($transportCost) && !$this->checkDouble($transportCost))
            {
                $error .= "Il costo di trasporto dei pezzi di ricambio deve essere intero oppure decimale (es. 200 oppure 230.20)<br>";
                $errors[8] = true;
            }

            if($error != "")
            {
                $errorReturn['message'] = $error;
                $errorReturn['errors'] = $errors;
                return $errorReturn;
            }
            
            $rates = $this->getRates();
            $WCost = $rates[0]->value*$totalWHours;
            $TCost = $techNum*$rates[1]->value*$totalTHours;
            $kmCost = $rates[2]->value*$totalTHours;
            $fixCost = $fix ? $rates[3]->value : 0.0;
            $fixRate = $fix ? $rates[3]->value : 0.0;

            $totalServices = $WCost+$TCost+$kmCost+$fixCost;
            $totalCost = $totalServices+$spareCost+$transportCost;

            $userID = $this->session->userdata('userID');

            $userID = isset($userID) ? $userID : 0;

            $fixValue = $fix ? 'true' : 'false';

            $query = $this->db->query("INSERT INTO report(date, ofo, callNumber, client, interventionPlace, techNum, totalWHours, totalTHours, km, fix, WRate, 
            TRate, kmRate, fixRate, WCost, TCost, kmCost, fixCost, totalServices, spareCost, transportCost, totalCost, insertedBy) VALUES ('".$date."', '".$ofo."', '".$callNumber."', '".$client."', 
            '".$interventionPlace."', ".$techNum.", ".$totalWHours.", ".$totalTHours.", ".$km.", ".$fixValue.", ".$rates[0]->value.", ".$rates[1]->value.", ".$rates[2]->value.", ".$fixRate.", ".$WCost.", ".$TCost.", ".$kmCost.", ".$fixCost.", 
            ".$totalServices.", ".$spareCost.", ".$transportCost.", ".$totalCost.", ".$userID.")");

            return true;
        }

        public function getReports($month = 0){

            $query = $this->db->query("SELECT * FROM report");
            $reports = $query->result();  

            if($month != 0)
            {
                $newReports = [];
                foreach ($reports as $row){
                    $pieces = explode("/", $row->date);
                    $monthCalc = $pieces[1];
                    $yearCalc = $pieces[2];
                    if(intval($month) == intval($monthCalc) && $yearCalc == date('Y'))
                        array_push($newReports, $row);
                }

                $reports = $newReports;

            }

            return $reports;
        }

        public function deleteReport($reportID){
            $query = $this->db->query("DELETE  FROM report WHERE id = ".$reportID."");
            return true;
        }

        public function getRates()
        {
            $query = $this->db->query("SELECT * FROM rates");
            $rates = $query->result();

            return $rates;
        }

        public function validateDate($date)
        {
            $d = DateTime::createFromFormat('d/m/Y', $date);
            return $d && $d->format('d/m/Y') === $date;
        }

        public function checkOfo($ofo)
        {
            if(strlen($ofo) != 8)
                return false;
            if($ofo[2] != '/')
                return false;
            /*if($ofo[0].$ofo[1] != date('y'))
                return false;*/
            if(preg_match('/\D/', substr($ofo, 3)))
                return false;

            return true;
        }

        public function checkCallNumber($callNumber)
        {
            if(strlen($callNumber) != 13)
                return false;
            if($callNumber[2] != '/')
                return false;
            if($callNumber[0].$callNumber[1] != date('y'))
                return false;
            if(preg_match('/\D/', substr($callNumber, 3)))
                return false;

            return true;
        }

        public function checkInt($number)
        {
            return preg_match('/^\d+$/', $number);
        }

        public function checkDouble($number)
        {
            $str = str_replace(",",".", $number);
            return preg_match('/^-?(?:\d+|\d*\.\d+)$/', $str);
        }


}

?>