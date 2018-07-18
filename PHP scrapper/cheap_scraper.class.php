<?php

require 'vendor/autoload.php';


class cheap_scraper
{
    const URI = 'https://www.cheapflightsfares.com/';

    protected $client;
    protected $airlines = [
        "AQ" => "9 Air",
        "9B" => "Accesrail",
        "6U" => "Acg Air Cargo",
        "JP" => "Adria Airways",
        "A3" => "Aegean Airlines",
        "EI" => "Aer Lingus",
        "NG" => "Aero Contractors",
        "P5" => "Aero Republica",
        "WV" => "Aero Vip Companhia Transportes",
        "H4" => "Aero4M",
        "7L" => "Aerocaribbean",
        "A4" => "Aerocomercial Oriente Norte",
        "VB" => "Aeroenlaces Nacionales",
        "SU" => "Aeroflot",
        "5P" => "Aerolinea Principal Chile",
        "AR" => "Aerolineas Argentinas",
        "2K" => "Aerolineas Galapagos",
        "P4" => "Aerolineas Sosa",
        "A8" => "Aerolink Uganda Limited",
        "5D" => "Aerolitoral",
        "VW" => "Aeromar",
        "AM" => "Aeromexico",
        "VH" => "Aeropostal",
        "HN" => "Afghan Jet International",
        "FK" => "Africa West Cargo  Ghd",
        "AW" => "Africa World Airlines",
        "8U" => "Afriqiyah Airways",
        "AH" => "Air Algerie",
        "G9" => "Air Arabia",
        "E5" => "Air Arabia Egypt",
        "9P" => "Air Arabia Jordan",
        "QN" => "Air Armenia",
        "UU" => "Air Austral",
        "W9" => "Air Bagan",
        "BT" => "Air Baltic",
        "AB" => "Air Berlin",
        "BP" => "Air Botswana",
        "RU" => "Air Bridge Cargo",
        "2J" => "Air Burkina",
        "BX" => "Air Busan",
        "SM" => "Air Cairo",
        "TY" => "Air Caledonie",
        "AC" => "Air Canada",
        "TX" => "Air Caraibes",
        "UY" => "Air Caucasus",
        "CA" => "Air China",
        "3E" => "Air Choice One",
        "4F" => "Air City",
        "XK" => "Air Corsica",
        "HF" => "Air Cote D Ivoire",
        "YN" => "Air Creebec",
        "EN" => "Air Dolomiti",
        "UX" => "Air Europa",
        "ED" => "Air Explore",
        "F4" => "Air Flamenco",
        "AF" => "Air France",
        "ZX" => "Air Georgian",
        "GL" => "Air Greenland",
        "GT" => "Air Guilin",
        "NY" => "Air Iceland",
        "KJ" => "Air Incheon",
        "AI" => "Air India",
        "IX" => "Air India Express",
        "3H" => "Air Inuit",
        "I9" => "Air Italy",
        "JM" => "Air Jamaica",
        "NQ" => "Air Japan",
        "K7" => "Air Kbz",
        "JS" => "Air Koryo",
        "AL" => "Air Leisure",
        "NX" => "Air Macau",
        "MD" => "Air Madagascar",
        "KM" => "Air Malta",
        "6T" => "Air Mandalay",
        "CW" => "Air Marshall Islands",
        "MK" => "Air Mauritius",
        "MC" => "Air Mobility Command",
        "9U" => "Air Moldova",
        "SW" => "Air Namibia",
        "NZ" => "Air New Zealand",
        "PX" => "Air Niugini",
        "4N" => "Air North",
        "YW" => "Air Nostrum",
        "OP" => "Air Pegasus",
        "GZ" => "Air Rarotonga",
        "PJ" => "Air Saint Pierre",
        "JU" => "Air Serbia",
        "L4" => "Air Service Liege",
        "HM" => "Air Seychelles",
        "4D" => "Air Sinai",
        "VT" => "Air Tahiti",
        "TN" => "Air Tahiti Nui",
        "TC" => "Air Tanzania",
        "6C" => "Air Timor",
        "8T" => "Air Tindi",
        "TS" => "Air Transat",
        "8C" => "Air Transport International",
        "3N" => "Air Urga",
        "NF" => "Air Vanuatu",
        "ZW" => "Air Wisconsin",
        "UM" => "Air Zimbabwe",
        "AK" => "Airasia Sdn Bhd",
        "D7" => "Airasiax Sdn Bhd",
        "SB" => "Aircalin",
        "SZ" => "Aircompany Somon Air",
        "HD" => "Airdo",
        "QP" => "Airkenya Aviation",
        "CG" => "Airlines Png",
        "TL" => "Airnorth",
        "AP" => "Airone S.P.A.",
        "2P" => "Airphil Express",
        "FL" => "Airtran Airways",
        "J6" => "Airways International",
        "IS" => "Ais Airlines B.V.",
        "2B" => "Ak Bars Aero",
        "6L" => "Aklak Air",
        "AS" => "Alaska Airlines",
        "AZ" => "Alitalia",
        "NH" => "All Nippon Airways",
        "G4" => "Allegiant Air",
        "UJ" => "Almasria Universal Airlines",
        "K4" => "Als Ltd",
        "6I" => "Alsie Express",
        "7S" => "Amadeus Pdf",
        "8Z" => "Amadeus Pdf",
        "9S" => "Amadeus Pdf",
        "MZ" => "Amakusa Airlines",
        "HP" => "Amapola Flyg Ab",
        "ZP" => "Amaszonas Del Paraguay",
        "Z8" => "Amaszonas S.A.",
        "AA" => "American Airlines",
        "2V" => "Amtrak",
        "OY" => "Andes Lineas Aereas",
        "IP" => "Apsara International Air",
        "FG" => "Ariana Afghan Airlines",
        "IZ" => "Arkia",
        "6A" => "Armenia Airways",
        "R7" => "Aserca",
        "HB" => "Asia Atlantic Airlines",
        "DM" => "Asian Air ",
        "KV" => "Asian Express Airline",
        "YJ" => "Asian Wings Airways",
        "OZ" => "Asiana Airlines",
        "RC" => "Atlantic Airways",
        "L5" => "Atlantique Air",
        "5Y" => "Atlas Air",
        "KK" => "Atlasjet Airlines",
        "UI" => "Auric Air",
        "GR" => "Aurigny Air",
        "HZ" => "Aurora Airlines",
        "AU" => "Austral Lineas Aereas",
        "OS" => "Austrian Airlines",
        "6V" => "Avanza",
        "YK" => "Avia Traffic Company",
        "AV" => "Avianca",
        "O6" => "Avianca Brazil",
        "AO" => "Avianova Lcc",
        "MV" => "Aviastar Mandiri",
        "GU" => "Aviateca",
        "X9" => "Avion Express",
        "J2" => "Azerbaijan Airlines",
        "AD" => "Azul Linhas Aereas",
        "JA" => "B H Airlines",
        "CJ" => "Ba Cityflyer",
        "J4" => "Badr Airlines",
        "UP" => "Bahamasair",
        "PG" => "Bangkok Airways",
        "5B" => "Bassaka Air",
        "BO" => "Bb Airways",
        "JV" => "Bearskin Airlines",
        "JD" => "Beijing Capital Airlines",
        "B2" => "Belavia",
        "L9" => "Belle Air",
        "LZ" => "Belle Air Company",
        "CH" => "Bemidji Airlines",
        "8E" => "Bering Air",
        "J8" => "Berjaya Air",
        "8H" => "Bh Air",
        "BG" => "Biman Bangladesh Airline",
        "NT" => "Binter Canarias",
        "BZ" => "Blue Bird Airways",
        "BV" => "Blue Panorama Airlines",
        "KF" => "Blue1",
        "BM" => "Bmi Regional",
        "OB" => "Boliviana De Aviacion",
        "YB" => "Bora Jet",
        "4B" => "Boutique Air",
        "5Q" => "Bqb Lineas Aereas",
        "DC" => "Braathens Regional",
        "E6" => "Bringer Air Cargo",
        "BA" => "British Airways",
        "SN" => "Brussels Airlines",
        "U4" => "Buddha Air",
        "FB" => "Bulgaria Air",
        "H6" => "Bulgarian Air",
        "XM" => "C.A.I. First S.P.A.",
        "VE" => "C.A.I. Second S.P.A",
        "MO" => "Calm Air International",
        "QC" => "Camair Co",
        "K6" => "Cambodia Angkor Air",
        "BD" => "Cambodia Bayon Airlines",
        "5T" => "Canadian North",
        "9K" => "Cape Air",
        "CV" => "Cargolux Airlines Int\'L",
        "BW" => "Caribbean Airlines",
        "CX" => "Cathay Pacific",
        "KX" => "Cayman Airways",
        "5J" => "Cebu Air",
        "C2" => "Ceiba Intercontinental",
        "5Z" => "Cemair",
        "9M" => "Central Mountain Air",
        "CE" => "Chalair Aviation",
        "6Q" => "Cham Wings Airlines",
        "C5" => "Champlain Enterprises",
        "9H" => "Changan Airlines",
        "RP" => "Chautauqua Airlines",
        "EU" => "Chengdu Airlines",
        "CI" => "China Airlines",
        "CK" => "China Cargo Airlines",
        "MU" => "China Eastern Airlines",
        "G5" => "China Express Airlines",
        "CZ" => "China Southern Airlines",
        "PN" => "China West Air",
        "OQ" => "Chongqing Airlines",
        "QI" => "Cimber A/S",
        "C7" => "Cinnamon Air",
        "QG" => "Citilink",
        "CF" => "City Airline",
        "E8" => "City Airways",
        "WX" => "Cityjet",
        "CC" => "Cm Airlines",
        "GY" => "Colorful Guizhou Airline",
        "MN" => "Comair",
        "BU" => "Compagnie Africaine D\'Aviation",
        "CP" => "Compass Airlines",
        "DE" => "Condor",
        "DF" => "Condor Berlin",
        "CO" => "Continental Airlines",
        "CM" => "Copa Airlines",
        "CD" => "Corendon Dutch Airlines",
        "SS" => "Corsair",
        "OU" => "Croatia Airlines",
        "C8" => "Cronos Airlines",
        "CU" => "Cubana De Aviacion",
        "OK" => "Czech Airlines",
        "D3" => "Daallo Airlines",
        "9J" => "Dana Airlines",
        "DX" => "Danish Air",
        "DL" => "Delta Airlines",
        "DQ" => "Delta Connection",
        "DO" => "Discovery Airways",
        "Z6" => "Dniproavia",
        "3D" => "Dokasch",
        "R6" => "Dot Lt",
        "DH" => "Douniah Airlines",
        "KA" => "Dragonair",
        "KB" => "Druk Air",
        "H7" => "Eagle Air",
        "B5" => "East African Safari Air",
        "EG" => "East Air",
        "EA" => "East Horizon Airlines",
        "T3" => "Eastern Airways",
        "U2" => "Easyjet",
        "WK" => "Edelweiss Air",
        "MS" => "Egyptair",
        "LY" => "El Al Israel Airlines",
        "7Q" => "Elite Airways",
        "EL" => "Ellinair",
        "EK" => "Emirates",
        "9E" => "Endeavor Air",
        "MQ" => "Envoy Air",
        "LC" => "Equatorial Congo Airline",
        "E4" => "Estelar Latinoamerica",
        "OV" => "Estonian Air",
        "ET" => "Ethiopian Airlines",
        "EY" => "Etihad Airways",
        "QY" => "European Air",
        "WL" => "European Coastal Airline",
        "9F" => "Eurostar",
        "EW" => "Eurowings",
        "BR" => "Eva Air",
        "5V" => "Everts",
        "EV" => "Expressjet Airlines",
        "FE" => "Far Eastern",
        "FN" => "Fastjet Airlines",
        "FJ" => "Fiji Airways",
        "AY" => "Finnair",
        "FC" => "Finncomm Airlines",
        "7F" => "First Air",
        "7B" => "Fly Blue Crane",
        "EF" => "Fly Caminter",
        "5L" => "Fly Salone",
        "5K" => "Fly Transportes Aereo",
        "BE" => "Flybe",
        "FZ" => "Flydubai",
        "FY" => "Flyfirefly",
        "XY" => "Flynas",
        "ND" => "Fmi Air",
        "Q5" => "Forty Mile Air",
        "RD" => "French Military Force",
        "F9" => "Frontier Airlines",
        "JH" => "Fuji Dream Airlines",
        "FU" => "Fuzhou Airlines",
        "3G" => "Gambia Bird Airlines",
        "GC" => "Gambia Intl Airlines",
        "GA" => "Garuda Indonesia",
        "4G" => "Gazpromavia",
        "A9" => "Georgian Airways",
        "ST" => "Germania",
        "GM" => "Germania Flug Ag",
        "4U" => "Germanwings",
        "G6" => "Ghadames Air",
        "GH" => "Globus Llc",
        "Z5" => "Gmg Airlines",
        "G8" => "Go Airlines",
        "G7" => "Gojet Airlines",
        "CN" => "Grand China Air",
        "ZK" => "Great Lakes Aviation",
        "GX" => "Guangxi Beidu Gulf Airlines",
        "G2" => "Guinea Airlines",
        "GF" => "Gulf Air",
        "H1" => "Hahn Air",
        "HR" => "Hahn Air",
        "HU" => "Hainan Airlines",
        "H5" => "Haiti Aviation",
        "7Z" => "Halcyon Air Cabo Verde",
        "HA" => "Hawaiian Airlines",
        "BH" => "Hawkair",
        "YO" => "Heli Air",
        "UV" => "Helicopteros Del Sureste",
        "JB" => "Helijet International",
        "HJ" => "Hellas Jet",
        "2L" => "Helvetic Airways",
        "H3" => "Hermes Airlines",
        "H8" => "Hesa Airlines",
        "UD" => "Hex Air",
        "H9" => "Himalaya Airlines",
        "OI" => "Hinterland Aviation",
        "HC" => "Holidays Czech Airlines",
        "HX" => "Hong Kong Airlines",
        "UO" => "Hong Kong Express Airways",
        "AN" => "Hop Airlinair",
        "DB" => "Hop Brit Air",
        "YS" => "Hop Regional",
        "QX" => "Horizon Air",
        "MR" => "Hunnu Air",
        "IB" => "Iberia",
        "FW" => "Ibex Airlines",
        "FI" => "Icelandair",
        "V8" => "Iliamna Air",
        "6E" => "Indigo",
        "XT" => "Indonesia Airasia Extra",
        "7I" => "Insel Air International",
        "D6" => "Inter Air",
        "I7" => "Inter Iles Air",
        "4O" => "Interjet",
        "IR" => "Iran Air",
        "B9" => "Iran Air Tours",
        "NV" => "Iranian Naft Airline",
        "IA" => "Iraqi Airways",
        "WP" => "Island Air",
        "Q2" => "Island Aviation",
        "T6" => "Island Transvoyager",
        "WC" => "Islena Airlines",
        "6H" => "Israir Airlines",
        "JC" => "Japan Air Commuter",
        "JL" => "Japan Airlines",
        "JZ" => "Jatayu Gelang Sejahtera",
        "J9" => "Jazeera Airways",
        "QK" => "Jazz Aviation",
        "9W" => "Jet Airways",
        "JF" => "Jet Asia Airways",
        "S2" => "Jet Lite",
        "JO" => "Jet Time",
        "LS" => "Jet2.Com",
        "TB" => "Jetairfly",
        "B6" => "Jetblue",
        "GK" => "Jetstar",
        "JQ" => "Jetstar",
        "3K" => "Jetstar Asia",
        "BL" => "Jetstar Pacific Airlines",
        "RY" => "Jiangxi Air",
        "LJ" => "Jin Air",
        "3B" => "Job Air",
        "R5" => "Jordan Aviation",
        "JR" => "Joy Air",
        "KC" => "Jsc Air Astana",
        "DV" => "Jsc Aircompany Scat",
        "R3" => "Jsc Aircompany Yakutia",
        "D9" => "Jsc Donavia",
        "IH" => "Jsc Irtysh-Air",
        "ZS" => "Jsc Kazaviaspas",
        "5N" => "Jsc Nordavia",
        "HO" => "Juneyao Airlines",
        "RQ" => "Kam Air",
        "5R" => "Karthago Airlines",
        "M5" => "Kenmore Air",
        "4K" => "Kenn Borek Air",
        "KQ" => "Kenya Airways",
        "KW" => "Kharkiv Airlines",
        "2S" => "Kinda Airlines",
        "WA" => "Klm Cityhopper",
        "KL" => "Klm Royal Dutch Airlines",
        "7K" => "Kogalymavia Airlines",
        "KE" => "Korean Air",
        "KY" => "Kunming Airlines",
        "KU" => "Kuwait Airways",
        "LK" => "Kyrgyz Airlines",
        "6K" => "Kyrgyz Trans Avia",
        "WJ" => "Labrador Airways Limited",
        "LR" => "Lacsa",
        "TM" => "Lam Mozambique",
        "LA" => "Lan Airlines",
        "UC" => "Lan Chile Cargo",
        "4C" => "Lan Colombia Airlines",
        "LP" => "Lan Peru",
        "XL" => "Lanecuador Aerolane Sa",
        "QV" => "Lao Airlines",
        "LF" => "Lao Central Airlines",
        "JJ" => "Latam Airlines Brazil",
        "LB" => "Lepl",
        "HE" => "Lgw Luftfahrtges Walter",
        "LI" => "Liat",
        "LN" => "Libyan Airlines",
        "IK" => "Llc Ikar",
        "LM" => "Loganair",
        "LO" => "Lot Polish Airlines",
        "LH" => "Lufthansa",
        "LT" => "Lufthansa Cityline",
        "CL" => "Lufthansa Cityline Gmbh",
        "LG" => "Luxair",
        "W5" => "Mahan Airlines",
        "MH" => "Malaysia Airlines",
        "MA" => "Malev Hungarian Airlines",
        "OD" => "Malindo Airway",
        "TF" => "Malmo Aviation",
        "RI" => "Mandala Airlines",
        "AE" => "Mandarin Airlines",
        "JE" => "Mango",
        "7Y" => "Mann Yadanarpon Airlines",
        "MP" => "Martinair",
        "L6" => "Mauritanian Airlines Int",
        "VM" => "Max Air",
        "MY" => "Maya Island Air",
        "VL" => "Med View Airlines",
        "LV" => "Mega Maldives",
        "JI" => "Meraj Air",
        "IG" => "Meridiana Fly",
        "YV" => "Mesa Airlines",
        "MX" => "Mexicana",
        "LL" => "Miami Air International",
        "OM" => "Miat Mongolian Airlines",
        "8G" => "Mid Africa Aviation",
        "ME" => "Middle East Airlines",
        "MJ" => "Mihin Lanka",
        "MW" => "Mokulele Flight",
        "2M" => "Moldavian Airlines",
        "QM" => "Monacair",
        "ZB" => "Monarch Airlines",
        "YM" => "Montenegro Airlines",
        "5M" => "Montserrat Airways",
        "3R" => "Moskovia Airlines",
        "M9" => "Motor-Sich Jsc",
        "UB" => "Myanmar National Airlines",
        "IC" => "Nacil Indian Airline",
        "T2" => "Nakina Air",
        "IN" => "Nam Air",
        "9Y" => "National Airways",
        "NC" => "National Jet Systems",
        "ON" => "Nauru Airlines",
        "ZN" => "Naysa",
        "RA" => "Nepal Airlines",
        "EJ" => "New England Airlines",
        "E3" => "New Gen",
        "JN" => "New Livingston",
        "JX" => "Nice Helicopteres",
        "HG" => "Niki",
        "DD" => "Nok Air",
        "XW" => "Nokscoot Airlines",
        "N6" => "Nomad Aviation",
        "NA" => "North American Airlines",
        "M3" => "North Flying As",
        "HW" => "North Wright Air",
        "J3" => "Northwestern Air Lease",
        "D8" => "Norwegian Air Int\'L",
        "DY" => "Norwegian Air Shuttle",
        "DU" => "Norwegian Long Haul As",
        "N9" => "Nova Airlines",
        "OA" => "Olympic Air",
        "WY" => "Oman Air",
        "8Q" => "Onur Air",
        "EC" => "Openskies",
        "R2" => "Orenair",
        "OC" => "Oriental Air Bridge",
        "3F" => "Pacific Airways",
        "8P" => "Pacific Coastal Airlines",
        "LW" => "Pacific Wings",
        "PK" => "Pakistan International",
        "7N" => "Pan American World",
        "8A" => "Panama Airways",
        "HI" => "Papillon Airways",
        "2Z" => "Passaredo Transportes",
        "MM" => "Peach Aviation",
        "PC" => "Pegasus Airlines",
        "KS" => "Penair",
        "PE" => "Peoples Viennaline",
        "YP" => "Perimeter Aviation",
        "P9" => "Peruvian Air Line",
        "PR" => "Philippine Airlines",
        "F6" => "Plus Ultra",
        "PU" => "Plus Ultra Lineas Aereas",
        "Z3" => "Pm Air",
        "DP" => "Pobeda Airlines",
        "PI" => "Polar Airlines",
        "YQ" => "Polet Airlines",
        "OL" => "Polynesian",
        "PD" => "Porter Airlines",
        "NI" => "Portugalia",
        "PW" => "Precision Air",
        "PF" => "Primera Air Scandinavia",
        "P0" => "Proflight Commuter",
        "PB" => "Provincial Airlines",
        "OH" => "Psa Airlines",
        "QZ" => "Pt Indonesia Airasia",
        "IW" => "Pt Wings Abadi Airlines",
        "ZR" => "Punto Azul",
        "QF" => "Qantas Airways",
        "QR" => "Qatar Airways",
        "IQ" => "Qazaq Air",
        "QB" => "Qeshm Air",
        "RT" => "Rainbow Airlines",
        "7H" => "Ravn Akaska",
        "WZ" => "Red Wings Airlines",
        "8N" => "Regional Air Services",
        "ZL" => "Regional Express",
        "R4" => "Reliable Unique",
        "4R" => "Renfe Viajeros",
        "YX" => "Republic Airline",
        "RR" => "Royal Air Force",
        "AT" => "Royal Air Maroc",
        "BI" => "Royal Brunei",
        "RL" => "Royal Falcon",
        "RJ" => "Royal Jordanian",
        "DR" => "Ruili Airlines",
        "7R" => "Rusline",
        "RM" => "Rutaca",
        "FR" => "Ryanair",
        "PV" => "Saint Barth Commuter",
        "RZ" => "Sansa",
        "S3" => "Santa Barbara Airlines",
        "6W" => "Saratov Airlines",
        "SP" => "Sata Air Acores",
        "S4" => "Sata Azores Airlines",
        "SV" => "Saudi Arabian Airlines",
        "6S" => "Saudi Gulf Airlines",
        "SK" => "Scandinavian Airlines",
        "YR" => "Scenic Airlines",
        "TZ" => "Scoot",
        "BB" => "Seaborne Airlines",
        "XO" => "Seair",
        "DN" => "Senegal Airlines",
        "D2" => "Severstal Air",
        "NL" => "Shaheen Air Intl",
        "SC" => "Shandong Airlines",
        "FM" => "Shanghai Airlines",
        "ZH" => "Shenzhen Airlines",
        "5E" => "Siam Ga",
        "S7" => "Siberia Airlines",
        "3U" => "Sichuan Airlines",
        "MI" => "Silkair",
        "3M" => "Silver Airways",
        "SQ" => "Singapore Airlines",
        "ZY" => "Sky Airlines",
        "ZA" => "Sky Angkor Airlines",
        "GQ" => "Sky Express",
        "TE" => "Sky Taxi",
        "Q7" => "Skybahamas Airlines",
        "GW" => "Skygreece Airlines",
        "F3" => "Skyking",
        "BC" => "Skymark Airlines",
        "6J" => "Skynet Asia Airways",
        "NB" => "Skypower Express",
        "OO" => "Skywest Airlines",
        "C9" => "Skywise",
        "S5" => "Small Planet",
        "P7" => "Small Planet Airline",
        "M4" => "Smart Aviation",
        "2E" => "Smokey Bay Air",
        "2C" => "Sncf",
        "IE" => "Solomon Airlines",
        "S8" => "Sounds Air",
        "SA" => "South African Airways",
        "9X" => "Southern Airways",
        "WN" => "Southwest Airlines",
        "JK" => "Spanair",
        "5W" => "Speed Alliance Westbahn",
        "SG" => "Spicejet",
        "NK" => "Spirit Airlines",
        "9C" => "Spring Airlines",
        "IJ" => "Spring Airlines",
        "UL" => "Srilankan Airlines",
        "4S" => "Star Airways",
        "7G" => "Star Flyer",
        "S9" => "Starbow",
        "RE" => "Stobart Air",
        "8F" => "Stp Airways",
        "SD" => "Sudan Airways",
        "6G" => "Sun Air Express Llc",
        "EZ" => "Sun Air Of Scandinavia",
        "SY" => "Sun Country",
        "XQ" => "Sun Express",
        "WG" => "Sunwing Airlines",
        "PY" => "Surinam Airways",
        "HS" => "Svenska Direktflyg Ab",
        "LX" => "Swiss International",
        "7E" => "Sylt Air Gmbh",
        "FS" => "Syphax Airlines Sa",
        "RB" => "Syrian Arab Airlines",
        "DT" => "Taag",
        "HH" => "Taban Airlines",
        "TA" => "Taca International Airlines",
        "7J" => "Tajik Air",
        "EQ" => "Tame Linea Aerea Del Ecuador",
        "QT" => "Tampa Cargo",
        "4E" => "Tanana Air",
        "TQ" => "Tandem Aero",
        "TP" => "Tap Portugal",
        "K3" => "Taquan Air",
        "RO" => "Tarom",
        "B3" => "Tashi Air",
        "U9" => "Tatarstan Air",
        "FD" => "Thai Airasia",
        "XJ" => "Thai Airasia",
        "TG" => "Thai Airways",
        "SL" => "Thai Lion Mentari",
        "WE" => "Thai Smile Airways",
        "VZ" => "Thai Vietjet Air",
        "2H" => "Thalys International",
        "DK" => "Thomas Cook Airlines",
        "GS" => "Tianjin Airlines",
        "3P" => "Tiara Air Aruba",
        "TT" => "Tiger Airways Australia",
        "DG" => "Tigerair Philippines",
        "IT" => "Tigerair Taiwan",
        "ZT" => "Titan Airways",
        "C3" => "Trade Air",
        "AX" => "Trans States Airlines",
        "PH" => "Transavia Denmark",
        "TO" => "Transavia France",
        "8B" => "Transnusa Aviation",
        "4P" => "Travel Air",
        "3Z" => "Travel Service Polska",
        "T4" => "Trip",
        "X3" => "Tuifly",
        "OR" => "Tuifly Netherlands",
        "TU" => "Tunisair",
        "TK" => "Turkish Airlines",
        "PS" => "Ukraine Intl Airlines",
        "B7" => "Uni Airways",
        "UA" => "United Airlines",
        "4H" => "United Airways Bangladesh ",
        "UQ" => "Urumqi Airlines",
        "BS" => "Us-Bangla Airlines",
        "UT" => "Utair Aviation Jsc",
        "HY" => "Uzbekistan Airways",
        "ZV" => "V Air",
        "VF" => "Valuair",
        "V9" => "Van Air Europe",
        "JW" => "Vanilla Air",
        "VC" => "Via Airlines",
        "VJ" => "Vietjet Aviation",
        "VN" => "Vietnam Airlines",
        "BF" => "Vincent Aviation",
        "VX" => "Virgin America",
        "VS" => "Virgin Atlantic",
        "VA" => "Virgin Australia",
        "UK" => "Vistara",
        "Y4" => "Volaris",
        "V7" => "Volotea",
        "G3" => "Vrg Linhas Aereas S A",
        "VY" => "Vueling Airlines",
        "WT" => "Wasaya Airways",
        "WH" => "West African Airlines",
        "9L" => "West Link Airways",
        "WS" => "Westjet",
        "WR" => "Westjet Encore",
        "WW" => "Wow Air",
        "MF" => "Xiamen Airlines",
        "SE" => "Xl Airways",
        "YC" => "Yamal Airlines",
        "Y8" => "Yangtze River Express",
        "Y2" => "Ygnus Air",
        "A6" => "Yunnan Hong Tu Airlines ",
        "YI" => "Yunnan Yingan Airline",
        "ZO" => "Zagros Airlines",
        "Z4" => "Zagros Jet",
        "B4" => "Zanair",
        "GJ" => "Zhejiang Loong Airlines",
    ];
    protected $debug = true;
    protected $logBuffer = '';

    /**
     * cheap_scraper constructor.
     */

    public function __construct()
    {

// get a random user agent
$useragent= \Campo\UserAgent::random();

        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $config = [
            'base_uri' => self::URI,
             'User-Agent' => $useragent,
            'cookies' => $jar,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ];
        file_put_contents(__CLASS__.'.log', '');
        $this->client = new \GuzzleHttp\Client($config);
    }

    public function verify($fromCode, $toCode, $fromDate, $toDate, $airline, $price, $ratio, $class)
    {
        $this->logBuffer = '';
        $this->log(__METHOD__." ".json_encode(func_get_args()));
        $result = false;
        try {
            $airlineCode = 'All';//$this->findAirlineCode($airline);

            //$this->log(__METHOD__." $airline - $airlineCode");
            $from = $this->getCity($fromCode);
            $to = $this->getCity($toCode);
            $fromDate = substr($fromDate, 5).'-'.substr($fromDate, 0, 4);
            $toDate = substr($toDate, 5).'-'.substr($toDate, 0, 4);

            $result = $this->check($from, $to, $fromDate, $toDate, $airlineCode, $price, $ratio, $class);
        } catch (Exception $e) {
            $this->log($e->getMessage());
            $result = false;
        }

        $this->writeLog();

        return $result;
    }

    protected function findAirlineCode($airline)
    {
        $airline = strtolower($airline);
        foreach ($this->airlines as $code => $airlineName) {
            $airlineName = strtolower($airlineName);
            if (strstr($airlineName, $airline)) {
                //$this->log('Found airline: '.$airlineName);
                return $code;
            }
        }

        throw new Exception('Airline not found: '.$airline);
    }

    protected function getCity($cityCode)
    {
        //$this->log(__METHOD__." $cityCode");
        try {
            $resp = $this->client
                ->get('get_city_list', [
                    'query' => [
                        'type' => 'flight',
                        'term' => $cityCode,
                    ],
                ]);

            $res = json_decode($resp->getBody()->getContents());

            if ($res === null || !is_array($res) || count($res) < 1) {
                throw new Exception('Cannot read body');
            }

            return $res[0];
        } catch (Exception $e) {
            $this->log($e->getMessage());
            throw new Exception('City not found:  '.$cityCode);
        }
    }

    /**
     * optradio:on
     * tripType:2
     * pageType:home
     * pageID:home
     * froCity:Chicago(ORD), O Hare Intl [Illinois], US
     * toCity:Shanghai(PVG), Pudong Intl, CN
     * froDate:09-28-2017
     * toDate:10-23-2017
     * adult:1
     * child:0
     * infant:0
     * infantWs:0
     * cabinClass:Economy
     * _directFlight:on
     * returnFroCity:
     * returnToCity:
     * airlines:AC
     * hfTripType:2
     */
    protected function check($from, $to, $fromDate, $toDate, $airlineCode, $price, $ratio, $class = "Economy")
    {
        $id = substr(sha1(time()), 0, 12);
        $default_params = [
            'optradio' => 'on',
            'tripType' => '2',
            'pageType' => 'home',
            'pageID' => 'home',
            'adult' => '1',
            'child' => '0',
            'infant' => '0',
            'infantWs' => '0',
            'cabinClass' => $class,
            '_directFlight' => 'on',
            'returnFroCity' => '',
            'returnToCity' => '',
            'hfTripType' => '2',
        ];

        $set_params = [
            'froCity' => $from,
            'toCity' => $to,
            'froDate' => $fromDate,
            'toDate' => $toDate,
            'airlines' => $airlineCode,
        ];

        $form_params = $set_params + $default_params;
        $this->log(json_encode($set_params));
        try {
            $resp = $this->client->post('search/id/'.$id,
                [
                    'form_params' => $form_params,
                ]);


            $resp = $this->client->get('PostSearchFlight/'.$id);

            $body = $resp->getBody()->getContents();
            $json = json_decode($body);
            if ($json === null || !isset($json[0])) {
                throw new Exception('Bad response');
            }
            $json = $json[0];

            if ($json->responseStatus->Status !== 0) {
                throw new Exception('Bad input: '.$json->responseStatus->ErrorDescription);
            }

            if (!isset($json->airlineStop)) {
                throw new Exception('No results found');
            }
            $airlinesData = $json->airlineStop;

            return $this->findPrice($airlinesData, $price * $ratio);
        } catch (Exception $e) {
            throw new Exception('Error fetching search results: '.$e->getMessage());
        }
    }

    protected function findPrice($data, $maxPrice)
    {
        $prices = [];
        foreach ($data as $d) {
            $this->log(__METHOD__.' '.json_encode($d));

            $fields = [
                'nonStopPrice',
                'oneStopPrice',
                'twoStopPrice',
            ];

            foreach ($fields as $field) {
                if (isset($d->{$field})) {
                    $checkedPrice = $d->{$field};
                    if ($checkedPrice > 0 && $checkedPrice < $maxPrice) {
                        $this->log(__METHOD__." found price - ".$checkedPrice);
                        $prices[] = $checkedPrice;
                    }
                }
            }
        }
        if (count($prices) >= 1) {
            $minPrice = min($prices);
            $this->log(__METHOD__." found min price - ".$minPrice);
            return $minPrice;
        }

        throw new Exception('Prices not in range');
    }

    protected function log($text)
    {
        if ($this->debug) {
            $this->logBuffer .= $text.PHP_EOL;
        }
    }

    public function writeLog()
    {
        file_put_contents(__CLASS__.'.log', $this->logBuffer.PHP_EOL, FILE_APPEND);
    }
}

