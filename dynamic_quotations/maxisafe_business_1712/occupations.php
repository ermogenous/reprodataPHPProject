<?
$occupation_fire_rates = array(
1 => 0.0015,
2 => 0.0016,
3 => 0.0017,
4 => 0.002
);

$occupation_theft_rates = array(
1 => 0.00125,
2 => 0.00135,
3 => 0.00150,
4 => 0.00160,
5 => 0.00175
);

//based on fire class
$occupations_general_excess = array(
1 => 150,
2 => 250,
3 => 400,
4 => 500
);

//based on theft class
$occupations_malicious_damage_excess = array(
1 => 450,
2 => 450,
3 => 600,
4 => 850,
5 => 1000
);

$occupations_storm_tempest_excess = array(
1 => 450,
2 => 450,
3 => 450,
4 => 450
);

//based on theft class
$occupations_theft_excess = array(
1 => 150,
2 => 250,
3 => 450,
4 => 850,
5 => 1500
);

$occupations_list = "6127#1-1#Αγροτική Οργάνωση#Agriculture Association
6267#2-2#Αγροτουριστικό κατάλυμα#Agrotourism house
281#1-2#Αθλητικές Εγκαταστάσεις#Sports establishments
282#3-1#Αίθουσα Δεξιώσεων#Entertainment hall
6337#1-1#Ακτινολογικό Κέντρο#Radiological Center
283#3-1#Αλευροποιοί#Flourmill owners
285#1-2#Ανθοπωλείο#Flower Shop
6054#3-2#Αντιπροσωπεία Οινοπνευματοδών Ποτών#Alcoholic Drinks Distributors
6165#2-2#Αποθήκη#Warehouse
327#4-2#Αποθήκη Δερμάτων#Leather Warehouse
6255#4-1#Αποθήκη Διαφημιστικών Εντύπων#Advertising Forms Storage
5491#3-2#Αποθήκη Ειδών Ένδυσης#Clothing Warehouse
5429#4-2#Αποθήκη Ειδών Ένδυσης & Υπόδησης#Clothing & Footwear Warehouse
6002#2-2#Αποθήκη ειδών θαλάσσης#Marine Equipment Warehouse
5170#3-3#Αποθήκη Επίπλων#Furniture Warehouse
5853#1-2#Αποθήκη Ζαχαροειδών#Sugar Warehouse
6016#3-1#Αποθήκη Ζωοτροφών#Animal Feed Warehouse
5596#3-3#Αποθήκη Ηλεκτρικών Συσκευών#Appliance Warehouse
286#2-2#Αποθήκη μαρμάρων και γρανιτών#Marble & Granite Warehouse
5597#2-2#Αποθήκη Μηχανών Γραφείου#Office Machinery Store
6000#2-1#Αποθήκη οικιακού & κουζινικού εξοπλισμού#Cutlery & Kitchen Equipment Warehouse
6147#2-2#Αποθήκη Παιδικών Καλλυντικών#Child Cosmetic Warehouse
5835#2-2#Αποθήκη Ποδηλάτων#Bicycle Warehouse
5836#2-3#Αποθήκη τουριστικών ειδών#Souvenir goods Warehouse
5593#1-2#Αποθήκη Τροφίμων και Ροφημάτων#Food & Beverage Store
6106#2-2#Αποθήκη Υαλικών & Είδη Δώρου#Gift & Glassware Warehouse
5840#4-4#Αποθήκη Φαρμάκων#Medicines Warehouse
5849#1-2#Αποθήκη(ες) Εργαλείων#Tools Warehouse(s)
288#3-1#Αρτοποιείο#Bread industry
289#1-1#Αρχιτεκτονικό Γραφείο#Architects Office
290#2-2#Αρωματοπωλείο#Perfumery Shop
5238#1-1#Ασφαλιστική Εταιρεία#Insurance Company
5775#3-3#Ατελιέ Μόδας#Fashion Atelie
291#2-1#Ατμοκαθαριστές#Dry cleaners
294#4-1#Βαφείο Αυτοκινήτων#CAR PAINTING
295#2-1#Βαφείο σπιτιών#House painters
296#2-1#Βαφείο υφασμάτων#Cotton Fabric dyer Industry
299#1-1#Βιβλιοπωλείo#Bookshop
300#1-2#Βιομηχανία Αεριούχων Ποτών#Soft drinks industry
302#1-1#Βιομηχανία Αλλαντικών#Smoked meat industry
303#4-1#Βιομηχανία Απορυπαντικών#Detergents industry
304#3-2#Βιομηχανία Βαλίτσων#Suitcases industry
301#4-4#Βιομηχανία Κατασκευής Φαρμάκων#Pharmaceutical industry
6239#2-1#Βιομηχανία Κρεάτων#Meat Industry
6246#4-1#Βιομηχανία Παρασκευής Βιοαερίου#Biogas Industry
305#4-1#Βιομηχανία Υφασμάτων#Cotton Fabric Industry
306#4-1#Βιοτεχνία Αέριων Βιομηχανικής Χρήσης#Industrial gaz use Industry
284#3-1#Βιοτεχνία Αμαξωμάτων#Car Bodies Industry
328#3-1#Βιοτεχνία Δερμάτων#Leather Industry
5773#4-1#Βιοτεχνία Κατασκευής Καπέλλων#Hut Manufacturers
4361#2-1#Βιοτεχνία Μεταξοτυπίων#Silk industry
4369#3-1#Βιοτεχνία Οξυγονοκολλήσεων#Torch welder industry
5435#1-2#Βιοτεχνία παρασκευής χυμών#Manufacture of juices
606#4-1#Βιοτεχνία χαρτιού#Paper goods manufacturer
307#3-1#Βυρσοδέψεις - Επεξεργαστές Δερμάτων#Tanner
309#2-1#Γαλακτοκομείο#Milk Industry
310#4-1#Γαλβανιστές Μετάλλων#Metal coater
3687#2-2#Γενικό Εμπόριο#General Trade
313#1-1#Γεωπόνοι#Agriculturists
315#1-1#Γεωργικές Επιχειρήσεις#Farming Industry
5742#1-1#Γεωργοκτηνοτρόφοι#Farmer-Breeders
6023#2-1#Γήπεδο με Κτιριακές Εγκαταστάσεις#Athletic Field & Building
5656#1-1#Γηροκομείο#Nursing Home
317#1-1#Γραφειακές Εργασίες#Office general services
6015#1-1#Γραφείο Ασφαλιστικής Διαμεσολάβησης#Insurance Intermediary office
349#1-1#Γραφείο εκτιμήσεων ζημιών#Assessors office
350#1-1#Γραφείο εκτιμήσεων ζημιών MARINE CARGO#Assessors office of MARINE CARGO damages
6340#1-1#Γραφείο Ενημέρωσης Κοινού για Θέματα Ενέργειας#Energy Information Center
5607#3-1#Γραφείο Ενοικιάσεων Αυτοκινήτων#Car Rental
499#1-1#Γραφείο Ντετεκτιβς#Detectives office
5598#1-4#Γραφείο Πωλήσεων Σκαφών Αναψυχής#Yacht Sales Office
4355#1-1#Γραφείο Ταξί#Taxi drivers ofiice
321#1-1#Γυμναστήριο#Gym
6192#1-1#Γυμναστήριο - Κολυμβητήριο#Gym - Swimming Pool
6333#3-2#Γυράδικο#Doner Kebab Fast Food
6081#1-1#Δημαρχείο#Town Hall
329#1-1#Δημοσιογραφικό γραφείο#Journalists office
5345#1-1#Διαγνωστικό Κέντρο#Diagnostic Centre
330#1-1#Διακοσμητικό γραφείο#Interior Designers office
318#1-2#Διανομείς Γραφειακού εξοπλισμού#Office supplies distributors
6185#2-1#Διανομείς Μελανιών#Ink Distributors
331#4-1#Διανομείς Πετρελαίου#Oil distributors
5428#4-1#Διανομείς Υγραερίου#Liquid Gas Distribution
332#1-1#Διανομείς φαγητών#Food distributors
333#1-1#Διαφημιστικό γραφείο#Advertising office
4896#1-1#Διαχειριστική Επιτροπή#Communal Building Committee
5994#1-1#Διαχωρισμός Οικοπέδων#Plot Separation
335#1-1#Δικηγορικό γραφείο#Law office
336#3-4#Δισκοπωλείο-κασεττοπωλείο#Record / cassette shop
338#1-1#Εγκαταστάσεις Αντένων#Antenna installers
340#2-1#Εγκαταστάσεις Κλιματιστικών#Airconditioners installation
341#1-1#Εγκαταστάσεις Πισίνων#Swimming-pools installation
342#1-1#Εγκαταστάσεις Ρολών Παραθύρων#Window Blind Installation
343#2-1#Εγκαταστάσεις συναγερμών ασφαλείας#Security Alarm installers
6256#2-2#Εισαγωγείς-Διανομείς Ειδών Θαλλάσης#Imports & Distribution of Sea Products
6104#4-2#Εισαγωγές & Πωλήσεις Φυτοφαρμάκων#Pesticide Imports & Sales
6249#1-1#Εισαγωγές Ιατρικών Μηχανημάτων#Medical Machinery Importers
5595#3-4#Εισαγωγική Εταιρεία Φαρμάκων#Medicine Import Company
5615#2-1#Εισαγωγική Εταιρεία Χαλιών, Κουρτίνων και Blinds#Imports of Carpets, Blinds and Curtains
345#1-1#Εισπράκτορες#Collectors
5366#1-1#Εκδοτικός Οικος#Publishers Office
347#4-4#Εκθέσεις Αυτοκίνητων εξωτερικών χώρων#Car showroom - outside
348#4-4#Εκθέσεις Αυτοκίνητων εσωτερικών χώρων#Car showroom - inside
5899#2-1#Εκθεση Αλουμινίων#Aluminum Show
5341#2-3#Εκκλησία#Church
6128#1-1#Εκπαιδευτήριο Δημοτικής Εκπαίδευσης#Εκπαιδευτήριο Δημοτικής Εκπαίδευσης
5106#2-4#ΕΚΤΕΛΩΝΙΣΤΕΣ#CLEARING & FORWARDING AGENTS
351#2-1#Ελαιοτριβείο#Olive oil mill
4577#2-1#Ελαιοχρωματιστές#Oil Painters
5794#1-1#Εμπορίας & Επιδιορθώσεις Εμπορευματοκιβωτιών#Selling & Maintenance of Containers
6105#1-1#Εμπορικό & Βιομηχανικό Επιμελητήριο#Chamber of Commerce & Industry
3810#1-1#Εμπόριο#Trading
326#3-2#Εμπόριο δερμάτων#Leather importers
6181#2-2#Εμπόριο Ειδών Ένδυσης & Υπόδησης#Importers of shoes & clothing
5599#2-2#Εμπόριο και Συντήρηση Μηχανών Γραφείου#Office Machinery Trading & Maintenance
354#4-4#Εμπόροι Φαρμάκων#Importers of Chemicals
355#2-1#Εμφιαλωτήριο#Bottling business
4352#3-3#Εμφιαλωτήριο Οινοπνευματωδών ποτών#Alcoholic drinks factory
356#3-2#Ενδύματα (κατάστημα)#dress shop
357#4-1#Ενδύματα (ραφεία)#Tailors
4579#1-3#Ενοικιάσεις Μοτοσικλέτων#Motor Cycle Rental
358#1-1#Εξωτερικοί Πωλητές Ρολών Παραθύρων#Window Blind Salesmen Distributors
4576#1-1#Επενδύσεις Ενοικιάσεις Κτιρίων#Letting Company
359#1-1#Επεξεργασία Άλατος#Salt industry
360#4-2#Επιδιορθωσεις Ελαστικών#Tyre workers
361#2-2#Επιδιορθώσεις Τηλεοράσεων#Televisions repairs
5744#1-1#Επιδιώρθωση, Συντήρηση & Μόνωση Κτιρίων#General Fittings & Maintenance
362#3-1#Επιθεωρητές Ατμολέβητων#Steam boilers inspectors
5745#1-1#Επιμετρητές#Quantity Surveyor
363#3-3#Έπιπλα (έκθεση, κατάστημα)#Furniture Shop, Showroom
364#3-1#Επιπλοπειοίο#Furniture Factory
353#4-2#Επιχείρηση Ελαστικών αυτοκινήτων#Car tyre business
379#3-2#Εργαστήρι Ζαχαροπλαστικής#Pastry Manufacture
6202#2-1#Εργαστήριο Τροφίμων#Food Laboratory
5252#2-4#ΕΡΓΑΣΤΗΡΙΟ ΧΡΥΣΟΧΟΕΙΑΣ#Jewelery Laboratory
366#1-1#Εργάτες#Workers
6103#1-1#Εργατικές Υπηρεσίες#Εργατικές Υπηρεσίες
369#1-1#Εργοδηγοί#Foremen
370#1-1#Εργολάβοι κηδειών#Funeral Directors
5686#1-1#Εργολάβοι Οδοποιίας #Contractors of Road Construction
3869#1-1#Εργολάβοι Οικοδομών#Constractors
4353#1-1#Εργοληπτική Εταιρεία#Building & Construction company
5343#1-1#Εργοσάσιο Μαρμάρων#Marble Factory
5214#2-1#Εργοστάσιο γαλακτοκομικών προϊόντων#Dairy Factory
5060#3-1#Εργοστάσιο Επίπλων#Furniture Factory
5573#3-1#Εργοστάσιο Ζωοτροφών#Factory of Forages
5999#3-2#Εργοστάσιο Κατασκευής Ζαχαροειδών#Candy Factory
412#4-1#Εργοστάσιο κατασκευής πλαστικών σωλήνων#Plastic Manufacturing Industry
6191#2-2#Εργοστάσιο Κατασκευής Φωτοβολταϊκών#Photovoltaics Factory
5706#1-1#Εργοστάσιο Μελισσοκομίας#Apiculture Factory
6021#3-1#Εργοστάσιο Μεταξοτυπίας#Silk Industry
495#4-1#Εργοστάσιο Παραγωγής & Π/σεις Κεραμικών, Μαρμάρων & Γρανιτών#Factory & Sales of Ceramic, Marbles and Granites
6365#3-2#Εργοστάσιο Παραγωγής Μανιταριών#Mushroom Factory
371#2-3#Έργων τέχνης (κατάστημα)#Art goods shop
372#4-3#Εστιατόριo#Restaurant
6266#2-2#Εταιρεία αγροτουρισμού#Agrotourism company
6264#2-2#Εταιρεία Ανακύκλωσης Αυτοκινήτων#Car Recycling Company
3845#1-1#Εταιρεία Ανάπτυξης#Developers
6149#2-1#ΕΤΑΙΡΕΙΑ ΑΝΟΡΥΞΗΣ ΓΕΩΤΡΗΣΕΩΝ#Drilling Company
374#1-1#Εταιρεία Αποχετευτικά Έργα#Sewerage work
375#1-1#Εταιρεία Ασφαλιστικής Διαμεσολάβησης#Insurance intermediaries Company
5704#1-1#Εταιρεία Ασφαλιστικής Διαμεσολάβισης#Insurance Intermediary Company
316#1-1#Εταιρεία Γεωτρύσεων#Drilling Company
6336#1-1#Εταιρεία Διάθεσης Ασθενοφόρων#Ambulance Trading Company
5723#2-1#Εταιρεία Διανομής Προιόντων#Products Distributors
339#1-1#Εταιρεία εγκαταστάσεων και συντήρησης ανελκυστήρων#Lift maintenance & installation company
5799#2-3#Εταιρεία Εισαγωγών & Διανομής Εξαρτημάτων Αυτοκινήτων#Car Parts Imports & Distribution Company
5837#3-2#Εταιρεία Εισαγωγών & Πωλήσεων Παιδικών Ειδών#Imports & Sales of Children products
6107#2-2#Εταιρεία Εισαγωγών & Πωλήσεων Υαλικών & Ειδών Δώρων#Gift & Glassware Company
5594#1-1#Εταιρεία Εισαγωγών Βιολογικών Τουαλέτων#Biological Toilets Import Company
5521#1-1#Εταιρεία Εισαγωγών καλωδίων και άλλου εξοπλισμού#Cables & other equipment import company
6141#2-2#Εταιρεία Εισαγωγών Συμπληρωμάτων Διατροφής#Food Supplements Import Company
6241#2-1#Εταιρεία Εκτροφής Χοίρων#Breeding Pigs Company
5842#2-2#Εταιρεία εξοπλισμού οδοντιατρίων#Dentists Equipment supplier
5436#3-2#Εταιρεία Επεξεργασίας Πρώτων Υλών / Ειδών Ζαχαροπλαστικής#Pastry raw materials manufacture
5528#1-1#Εταιρεία Εφαρμογής Γιαλιών Οχημάτων#Vehicles windscreens application company
6032#3-1#Εταιρεία Θερμάνσεων & Υδραυλικών Εγκαταστάσεων#Heating and plumbing installation company
6215#3-2#Εταιρεία Κατασκευής Αμαξωμάτων#Vehicle Body Manufacturers
6311#1-1#Εταιρεία Κατασκευής Πισίνων#Pool Manufacturing Company
6097#2-1#Εταιρεία Κατασκευής Τσιμεντοσωλήνων#Concrete pipes Manufacturing Company
6247#3-1#Εταιρεία Κατασκευής Φουκούδων#Barbecue Equipment Manufacturers
6100#4-1#Εταιρεία κοπής πέτρας#Stone Company
6368#1-1#Εταιρεία Μελέτης και Κατασκευής#Study & Construction Company
5708#2-1#Εταιρεία Μεταφορών#Transport Company
484#2-1#Εταιρεία Μεταφορών Επίπλων#Furniture transportation company
5881#2-1#Εταιρεία Μεταφορών,Φορτοεκφορτώσεων & οικοδομικών εργασιών#Building, Transport & Construction Company
501#2-2#Εταιρεία Ξενοδοχειακού εξοπλισμού#Hotel equipment company
6263#3-1#Εταιρεία Ξυλουργικών και Μεταλικών Κατασκευών#Wood & Metal Constructions Comapny
5529#1-1#Εταιρεία Οδικής Βοήθειας#Road Assistance Company
5617#2-2#Εταιρεία Παραγωγής και Σκηνοθεσίας Ταινιών#Film Production & Direction company
6322#2-1#Εταιρεία παραδοσιακών κατασκευών#Traditional construction company
6186#1-1#Εταιρεία προϊόντων καθαρισμού & υγιεινής#Sale & Distribution of Cleaning & Hygienic products
4580#1-1#Εταιρεία Πυροσβεστήρων#Fire Extinguishing Company
6364#2-2#ΕΤΑΙΡΕΙΑ ΠΩΛΗΣΗΣ ΕΙΔΩΝ ΤΡΟΦΙΜΩΝ#Food Selling Company
544#1-1#Εταιρεία Σιδεροκατασκευών οικοδομικών έργων#Scaffolders Company
6148#3-1#ΕΤΑΙΡΕΙΑ ΣΙΔΕΡΟΜΕΤΑΛΛΟΥΡΓΙΚΕΣ ΚΑΤΑΣΚΕΥΕΣ#Iron Construction Company
3870#1-1#Εταιρεία Σκυροδέματος#Concrete Company
5797#1-1#Εταιρεία Συλλογής Σκυβάλων Ανακύκλωσης#Recycling Trash Collection Company
5088#1-1#Εταιρεία Συμβουλευτικών Υπηρεσιών#Business Consultancy
6055#3-1#ΕΤΑΙΡΕΙΑ ΤΟΡΝΑΔΟΡΩΝ & ΣΥΓΚΟΛΛΗΤΩΝ #ΕΤΑΙΡΕΙΑ ΤΟΡΝΑΔΟΡΩΝ & ΣΥΓΚΟΛΛΗΤΩΝ 
5531#1-2#Εταιρεία Τροφοδοσίας#Catering Company
6291#1-1#Εταιρεία Υπηρεσιών Ελέγχου και Δοκιμών#Control & Test Company
4373#1-1#Εταιρεία Φρουρών Ασφαλείας#Security Company
6203#1-1#Εταιρεία DYI & άλλου εξοπλισμού#DYI products and gypsum boards
376#2-1#Εφαρμογές Αλουμινίων#Aluminium installations
5194#3-1#Εφαρμογές Γυψοσανίδων #Plaster Boards Installations
5518#1-1#Εφορεία Δημοτικής Εκπαίδευσης#Eforia Demotikis Ekpedevsis
5517#1-1#Εφορεία Μέσης Εκπαίδευσης#Eforia Mesis Ekpedevsis
5519#1-1#Εφορεία Προδημοτικής Εκπαίδευσης#Eforia Prodimotikis Ekpedevs
378#1-2#Ζαχαροπλαστεία (κατάστημα)#Pastry shop
380#3-2#Ζυθοποιοί#Brewers
381#2-3#Ζωγραφικής (έκθεση)#Art exhibition
382#1-1#Ζωέμποροι#Animal importer
383#3-1#Ζωοτροφές (κατάστημα)#Animal feed shop
5234#2-1#Ηλεκτρικες εγκαταστασεις #Electric installations 
5211#2-1#Ηλεκτρικες εγκαταστασεις #Electric Installations
5711#2-1#Ηλεκτρολογικές & Τηλεφωνικές Εγκαταστάσεις#Phone & Electric Installations
387#3-2#Ηλεκτρολόγοι αυτοκίνητων#Electricians automotive
388#3-1#Ηλεκτρολόγοι Κατοικιών#Electricians residences
5206#2-1#Ηλεκτρομηχανολογικές εργολαβίες#Electromechanical contract works
4131#2-1#Ηλιακοί Θερμοσίφωνες#Solar Heaters
390#2-2#Θαλασσίων σπόρ (κατάστημα)#water sports shop
391#1-1#Θερμάνσεων& συστημάτων κλιματισμού (κατάστημα)#Heating and ventilation appliance shop
6160#1-2#Θερμοκήπιο#Greenhouse
392#1-1#Ιατρείο#Doctors' Office
6173#2-1#Ιατρικό Κέντρο#Medical Establishment
5439#1-1#Ιδιωτική Σχολή#Private School
5458#1-1#Ιδιωτικό Γραφείο Εξευρέσεως Εργασίας#Private Employee Company
6338#2-1#Ιδιωτικό Νοσοκομείο#Private Hospital
4378#1-1#Ιδιωτικό Φροντιστήριο#Private Tutorial center
395#2-2#Ινστιτούτο Αισθητικής#Beauty salon
5523#2-1#Ιχθυοκαλλιέργειες#Aquaculture
398#1-1#Ιχθυοπωλείο#Fishmonger
4380#4-1#Καθαρισμός και Βαφή Πλοίων#Boats painting & cleaning
401#3-1#Καθαριστές Ατμολέβητων#Steam boilers cleaners
402#1-1#Καθαριστές Γυαλλιών#Window cleaners
403#2-1#Καθαριστές Χαλιών#Carpets - cleaners
404#1-1#Καθαρίστριες οικ. βοηθοί#Cleaners, housmaids
405#1-1#Καλαθοποιοί#Basket makers
406#2-4#Καλλυντικά (κατάστημα)#cosmetics shop
407#1-1#Καλούπια - οικοδομές#Formwork
409#3-4#Καπνοπωλεία#tobacconist
408#3-4#Καπνοπωλεία#Tobacco Shop
410#2-1#Κατασκευαστές Αλουμινίων#Aluminium Installers
411#3-1#Κατασκευαστές Κεραμιδιών & Τούβλων#Bricks & Tiles Manufacturers
5408#2-1#Κατασκευαστές Πορτοπαραθύρων #Door Panel Manufacturers
413#3-1#Κατασκευαστές Ρολών Παραθύρων#Window Blind Manufacturers
4004#3-2#Κατασκευαστές Σκαφών#Hull Manufacture
414#3-1#Κατασκευαστές Στέγων#Roof contractors
415#3-1#Κατασκευαστές Στρωμάτων#Mattress manufacturer
416#2-1#Κατασκευαστές Ταπέλλων & Πινακίδων#Signs manufacturers
417#3-1#Κατασκευαστές Τέντων#Awnings manufacture
6200#3-1#Κατασκευαστές Τσιμεντομπλόκς#Cementblocks Manufacturers
5707#1-1#Κατασκευές Σταμποτών & Οικοδομών#Stamped Construction & Building
418#3-1#Κατασκευή και Μεταφορά Λιπασμάτων#Fertilizers manufacture transport
419#1-1#Κατασκευή Κατεψυγμένων Προϊόντων#Frozen food manufacturers
420#2-1#Κατασκευή Υδραυλικών μηχανημάτων#Hydraulic instruments manufacture
421#2-1#Κατασκηνώσεως είδη#camping shop
6339#2-1#Κατασκηνωτικός Χώρος#Camping Area
6197#2-1#Κατάστημα #Shop
422#2-3#Κατάστημα Αδασμολόγητων Ειδών#Duty free goods shop
424#1-3#Κατάστημα Αεριούχων Ποτών#Soda drinks manufacture
425#2-2#Κατάστημα Αθλητικών Ειδών#Sports goods (shop)
426#2-2#Κατάστημα Αθλητικών Ειδών#Sports goods shop
427#2-1#Κατάστημα Αλιείας είδη#fishing equipment
428#2-1#Κατάστημα Αλλαντικά (πρατήρια)#Delicatessen
429#2-3#Κατάστημα Ανταλλακτικά Αυτοκινήτων#Car spare parts shop
5601#1-3#Κατάστημα Αξεσουάρ#Accessories Shop
430#2-2#Κατάστημα Αποικιακών Ειδών#General Shop
287#2-4#Κατάστημα Αργυροχοοίας#Silversmith shop
293#3-1#Κατάστημα Βαλίτσων & Τσάντων#Suitcases / bags shop
308#1-1#Κατάστημα Γάλακτος & προϊόντων#Milk and dairy products shop
314#1-1#Κατάστημα Γεωργικών Ειδών#Agricultural goods shop
431#3-4#Κατάστημα δισκοπωλείων/dvd/cd#Records/dvd shop
337#1-3#Κατάστημα Δώρων#Gift shop
432#1-2#Κατάστημα δώρων#Gift shop
433#1-1#Κατάστημα Ειδών Αγγειοπλάστικής#Potters
344#2-2#Κατάστημα Ειδών Αλιείας#Fishing Equipment shop
311#1-2#Κατάστημα Ειδών Γάμου#Wedding goods shop
320#2-1#Κατάστημα ειδών γραφείου & σχολικών ειδών#Office Stationery shop
435#2-1#Κατάστημα Ειδών κατασκηνώσεως#Camping Shop
436#3-1#Κατάστημα ειδών κατοικίδιων ζώων#Pet shop
6126#4-2#Κατάστημα Ειδών Κυνηγίου#Κατάστημα Ειδών Κυνηγίου
5709#2-4#Κατάστημα Ειδών Προίκας#Dowry Goods Shop
4367#2-2#Κατάστημα ειδών Ταξιδίου#Travel items shop
584#1-2#Κατάστημα Ειδών Υγιεινής#Sanitary goods shop
6022#2-1#Κατάστημα Εκκλησιαστικών Ειδών#Church Material Shop
4616#4-2#Κατάστημα Ελαστικών#Tyre Shop
6053#3-1#Κατάστημα επιδιορθώσεων&πωλήσεων μεταχειρισμένων εξαρτημάτων#Sales & Repairs of used spare parts shop
319#3-1#Κατάστημα επίπλων Γραφείου #Office Furniture Shop
437#3-1#Κατάστημα έργων τέχνης#Art goods shop
385#3-3#Κατάστημα Ηλεκτρικών συσκευών#Electrical appliance shop
386#3-4#Κατάστημα Ηλεκτρολογικού υλικού #Electrological goods shop
389#3-4#Κατάστημα Ηλεκτρονικών συσκευών #Electronic appliance shop
439#2-4#Κατάστημα καλλυντικών#Cosmetics Shop
6287#2-4#Κατάστημα κινητής τηλεφωνίας#Mobile phones shop
440#2-4#Κατάστημα λευκών ειδών#White goods shop
5527#1-1#Κατάστημα Λιανικής Πώλησης#Retail Shop
6125#3-3#Κατάστημα με είδη βάφτισης και ρούχα#Christening & Clothing Shop
441#1-2#Κατάστημα Μουσικών Ειδών#Musical Instrument Shop
491#1-2#Κατάστημα Μουσικών οργάνων#musical instrument shop
588#3-4#Κατάστημα Πωλήσεων Ηλεκτρονικών Υπολογιστών#Computer sales shop
4358#4-1#Κατάστημα πωλήσεων ξυλείας#Wood sales shop
442#1-1#Κατάστημα πωλήσεων Οικοδομικών Υλικών#Building Materials Shop
605#4-1#Κατάστημα πωλήσεων χαλιών#Carpet sales shop
6321#1-1#Κατάστημα Πώλησης Ιατρικών Ειδών#Medical Shop
6001#2-2#Κατάστημα πώλησης καφέδων & σοκολάτων#Coffee & Chocolate Shop
4363#1-1#Κατάστημα πώλησης παιχνιδιών#Toy shop
591#3-1#Κατάστημα πώλησης Υφασμάτων#Fabric goods sales shop
4381#3-4#Κατάστημα Συστημάτων Θέρμανσης & Κλιματισμού#Heating and ventilation appliance shop
576#3-1#Κατάστημα Τουριστικών ειδών#Souvenir Shop
6303#2-1#Κατάστημα Υποδημάτων#Shoe Shop
5602#3-4#Κατάστημα Φυτοφαρμάκων#Pesticide Shop
4366#2-1#Κατάστημα χειροτεχνίας#Handicraft shop
443#4-1#Καταστήματα Βαφών και μπογιών#paints / varnishes
444#1-1#Καταστηματάρχες λιαν. πώλησης#Shop workers
445#2-1#Κατεδαφίσεις#Demolitions
446#3-1#Κατοικίδια ζώα (κατάστημα)#pet shop
6265#4-2#Καφε-μπαράκι#Coffee bar
6005#3-1#Καφενείο#Coffee Shop
6254#3-1#Καφεστιατόριο#Restaurant & Coffee shop
5330#3-1#Καφετερία Διαδικτύου#Internet Cafe
448#3-1#Καφετέριες#Coffee shops
5520#1-1#Κέντρο Απασχόλησης & Διαμονής Ατόμων με ειδικές ανάγκες#Center for Persons with Disabilities
6318#1-1#Κέντρο Ευημερίας & Φροντίδας #Care Center
6217#2-1#Κέντρο Ομορφιάς & Περιποίησης#Beauty Salon
450#2-1#Κεραμικής (εργαστήρι)#Pottery
451#3-1#Κηροποιοί#Chandlers
5774#3-1#Κινηματογράφος#Cinema
452#1-1#Κλάδεμα Δέντρων#Tree feller
4008#1-1#Κληρονόμοι#Heirs
453#1-1#Κλητήρες - εισπράκτορες#Messengers, collectors
454#1-1#Κλινικές#Clinics
5151#3-4#Κλινικό Εργαστήριο#Clinical Laboratory
5143#1-1#Κοινοτικό Συμβούλιο#Local Council Commitee
456#1-1#Κομμωτήρια / Κουρεία#Hair Salon
457#4-1#Κοντρα πλακε καπλαμαδες#Plywood varnishers
458#2-1#Κόπτες Γυαλιών#Glaziers
461#2-1#Κορνιζοποιείο#Framer
463#1-1#Κουρείς - κομμωτές#Hairdressers
464#2-1#Κρεοπωλεία#Butchery
466#1-1#Κτηματομεσίτες#Estate agents
4362#1-1#Κτηματομεσιτικό γραφείο#Estate agency
467#1-1#Κτηνίατροι#Veterinarians
468#1-1#Κτηνοτρόφοι#Cattle Breeder
469#3-1#Κωμοδρόμοι#Steel workers
470#1-1#Λατομία#Quarry
475#1-1#Λογιστικό Γραφείο#Accountants office
6174#1-1#Λογιστικός & Ελεγκτικός Οίκος#Accounting & Auditing Office
476#3-1#Λουστραδόροι#Varnishers
5346#3-1#Μ.Ο.Τ Κέντρο#M.O.T Center
478#1-1#Μασέρ#Masseur
481#3-1#Μεταλλικές Κατασκευές#Metal manufacturers
485#3-1#Μηχανικοί αυτοκινήτων#Car mechanics
486#2-1#Μηχανικοί μοτοσικλετών#Engineers motorcycles
488#3-1#Μηχανουργεία#machine works
487#3-1#Μηχανουργεία#Machine works
5759#2-1#Μοναστήρι#Monastery
489#2-1#Μονωτές#Insulation installers
490#1-1#Μοτοσικλέτες (κλειστός εκθεσιακός χώρος)#motorcycle showroom indoor
5897#3-2#Μουσική Σκηνή#Music Scene
5575#1-1#Μουσική Σχολή#Music School
493#1-1#Μπακάλικα#Grocers
494#2-3#Μπουτίκ#boutique
6017#4-1#Μπυραρία#Pub
5898#1-2#Ναυτηλιακή Εταιρεία#Shipping Company
496#1-1#Νεκροθάφτες#Grave-digger
4359#1-1#Νηπιαγωγείο#Nursery school
498#1-1#Νοσοκόμοι#Nurses
6056#4-4#Νυκτερινό Κέντρο Διασκέδασης#Night Club
5796#2-1#Ξενοδοχιακά Διαμερίσματα#Hotel Apartments
502#3-1#Ξυλεία – Πωλήσεις#Wood - Sales
503#3-1#Ξυλέμποροι#Wood tradesmen
504#3-1#Ξυλοσχίστες#Woodcutters
4356#3-1#Ξυλουργικές Εργασίες#Wood works
505#3-1#Ξυλουργοί#Woodworkers
507#1-1#Οδηγοί βαρεων οχηματων#Heavy vehicles drivers
510#1-1#Οδηγοί φορτηγών#Lorry drivers
4354#1-1#Οδοντιατρείο#Dentist Shop
511#1-1#Οδοντίατροι#Dentists
5604#1-1#Οδοντοτεχνικό Εργαστήριο#Dental Laboratory
513#1-1#Οικοδομικά υλικά (πωλήσεις)#building materials shop
514#1-1#Οικοδομικές Εργασίες#Construction works
515#3-3#Οινοπνευματωδών ποτών εμφιαλώσεις , παραγωγή#Distillery
5817#1-1#Ομοσπονδία#Federation
516#4-1#Οξυγονοκολλητές#Torch welders
517#5-5#Οπλοπωλεία#Gun maker
519#1-2#Οπτικοί οίκοι#Optician Shop
6161#1-1#Οργανωτές Γάμου#Wedding Planners
520#4-1#Ορυχεία#Mines
5142#1-5#Παιδότοπος#Playarea
6328#2-3#Παιχνίδια Ψυχαγωγίας#Fun Games
522#2-2#Παντοπωλεία#Grocery
523#4-1#Πελεκάνοι#Carpenter
524#2-4#Περιπτεριούχοι#Kiosk owners
4364#2-4#Περίπτερο#Kiosk
525#4-1#Πιτσαρία#Pizza parlour
526#3-1#Πλαστικά είδη (κατάστημα)#Plastic goods shop
528#2-1#Πλυντήρια – σιδερωτήρια#Launderette
5430#2-1#Πλυντήριο Αυτοκινήτων#Car Wash
529#2-1#Ποδήλατα (κατάστημα)#Bicycle shop
3979#4-1#Ποδοσφαιρικό Σωματείο#Football Club
530#1-1#Πολιτικοί Μηχανικοί#Civil engineers
5081#1-2#Πολιτιστικό Κέντρο#Cultural Centre
6276#2-2#Πολυκατάστημα#Superstore
6155#1-1#ΠΟΛΥΚΑΤΟΙΚΙΑ#Building
6009#1-5#Πρακτορείο Στοιχημάτων#Betting Shop
531#1-2#Πρατήρια Αεριούχων Ποτών#Soft Drinks Store
3877#4-2#Πρατήριο Βενζίνης#Petrol Station
4059#1-1#Πρόσκοποι#Boy-Scouts
5614#3-1#Πτηνοτροφείο#Poultry Factory
532#3-1#Πτηνοτροφές (κατάστημα)#Poultry shop
5722#1-1#Πωλήσεις Εμφιαλωμένου Νερού#Bottled Water Sales
5710#3-4#Πωλήσεις και Επιδιορθώσεις Οικιακών Συσκευών#Household Appliances Sales & Repairs
5490#2-2#Πώληση & Επιδιόρθωση Μοτοσυκλεττών#Sales and Motorcycles service
534#2-1#Πωλητές Αξεσουάρ αυτοκίνητων#Car asseccories salesmen
536#1-4#Πωλητές αυτοκίνητων#Car salesmen
539#2-1#Ραπτικής εργαστήρια#Sewing Shop
540#2-1#Ραπτικής υλικά#Sewing Materials
541#1-1#Ρυμουλκήσεις#Towing of vehicles
545#4-1#Σιδηρουργεία#Smitheries
546#4-1#Σιδηρουργοί#Blacksmiths
548#4-3#Σνακ μπαρ#Snack bar
549#4-3#Σουβλατζίδικα#Kebab house
550#4-2#Σταθμοί Βενζίνης με πλυντήριο#Petrol stations with car wash and SERVICE
551#4-2#Σταθμοί Βενζίνης χωρίς πλυντήριο#Petrol stations no car wash and SERVICE
552#4-1#Στεγνοκαθαριστήρια#dry cleaner
553#1-2#Στήσιμο σκαλοσιών#Scaffolding
556#3-1#Συγκολλητές#Solderers
5941#1-1#Συμβούλιο Αμπελοοινικών Προιόντων#Wine Products Board
5939#1-1#Συμβούλιο Υδατοπρομήθειας#Water Board
394#3-1#Συνεργείο Αυτοκινήτων#Garage 
6154#3-2#Συνεργείο Επιδιόρθωσης Ταχυτήτων#Gear Box Repair Garage
397#3-1#Συνεργείο Ισιωμάτων Οχημάτων#Car body repair station
4360#2-1#Συνεργείο μοτοσικλέτων#Engineers motorcycles
6080#1-1#Σφαγείο#Abbatoir
560#3-1#Σφραγίδες / χαρακτική / κλισέ#Printing stamp
561#1-1#Σχεδιαστές#Designer
562#2-1#Σχολές Ιππασίας#Riding schools
5409#2-1#Σχολή Καταδύσεων#Diving School
6298#2-1#Σχολή Κωμμοτικής#Hairdressing School
3885#1-1#Σχολή Χορού#Dance School
5533#1-1#Σχολική Εφορεία#Sholiki Eforia
563#2-1#Σωληνουργοί#Pipe Manufacturers
6172#2-1#Σωματείο#Club
564#3-2#Ταβέρνα#Tavern
566#1-1#Ταξιδιωτικοί υπάλληλοι#Travel agency employees
567#4-2#Ταπετσάρηδες#Upholsterers
568#1-3#Τεχνικοί Ηλεκτρονικών Υπολογιστών#Computer technician
569#1-1#Τεχνίτες#Technicians
4498#1-1#Τηλεοπτικό Κανάλι#TV Channel
570#2-1#Τοιχοκολλήσεις Διαφημίσεων#Advertising placard installers
6162#1-1#Τοπογραφικό Γραφείο#Topographic Office
571#2-1#Τοποθετήσεις Εναέριων Ηλεκτρικών Καλωδίων#Installers of overground Electric cables
573#1-1#Τοποθετητές Ταπέλλων & Πινακίδων#Signs installers
574#2-1#Τοποθετητές Τέντων#Awnings installers
575#1-1#Τορναδόροι#Turners
4462#1-1#Τουριστικά#Tourist office
4461#1-1#Τράπεζα#Bank
578#4-1#Τυπογραφεία#Printers
582#2-1#Υαλοκόπτες#Glaziers
583#2-1#Υαλωθέτες#Glass installers
585#2-1#Υδραυλικές Εγκαταστάσεις#Plumbing Installation
4611#2-2#Υπεραγορά#Supermarket
6214#1-1#Υπεράκτια Εταιρείας#Offshore Company
586#2-1#Υποδήματα (καταστήματα)#Shoe shop
587#2-1#Υποδηματοποιοί#Shoemakers
4575#2-1#Φάρμα#Farm
592#2-4#Φαρμακεία#Pharmacy
593#2-4#Φαρμακοποιοί#Pharmacists
5061#2-1#Φθαρτέμποροι#Perishable Goods Trader
3812#1-1#Φιλανθρωπικό Ίδρυμα #Charity Organisation
595#1-1#Φρουροί#Guards
596#2-1#Φρουταρία#Greengrocer
597#1-1#Φρουτέμποροι#Fruit Tradesmen
598#1-1#Φυσιοθεραπευτήριo#Physiotherapist
599#2-1#Φυτώριo#Garden center
600#2-1#Φωτιστικά είδη (κατάστημα)#light and light fittings shop
602#3-2#Φωτογραφίας (εργαστήρια)#photographic studio
603#2-2#Φωτογράφοι#Photographers
609#3-4#Χημικοί#Chemists
6003#3-1#Χοιροστάσιο#Pigsty
5600#1-1#Χρηματοδοτικός Οργανισμός#Finance Organization
5801#1-2#Χρηματοοικονομικός Οργανισμός #Bank
610#1-5#Χρυσοχοείο#Jewellery shop
611#4-1#Χυτήριο#Foundry
4155#1-1#Χωματουργικές Εργασίες#Excavation Works
6199#1-1#Χωριτική Αρχή#Local Council Commitee
612#4-2#Ψαροταβέρνα#Fish tavern
5572#4-3#Ψητοπωλείο#Grill House
615#2-1#Ψυκτικοί Θαλάμοι#Cold store workers
616#1-2#Ωδεία#Musical instrument teaching
617#1-5#Ωρολογοποιοί#Watchmakers
4166#2-1#Athletic Club#Αθλητικό Σωματείο
4817#3-2#M.O.T Centre#M.O.T Centre
";
?>