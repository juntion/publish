<?php
define('PURCHASE_TITLE_01', 'Beschaffungsauftrag');
define('PURCHASE_TITLE_02', 'Beschaffungsauftrag einfach erstellen, einreichen und verfolgen');

define('PURCHASE_FORM_01', 'Geben Sie bitte die folgenden Informationen zur schnellen und einfachen Bearbeitung ein.');
define('PURCHASE_FORM_02', 'Kontaktinformationen');
define('PURCHASE_FORM_03', 'Vorname');
define('PURCHASE_FORM_04', 'Nachname');
define('PURCHASE_FORM_05', 'E-Mail-Adresse');
define('PURCHASE_FORM_06', 'Telefonnummer');
define('PURCHASE_FORM_07', 'Auftragsinformationen');
define('PURCHASE_FORM_08', 'Auftragsnummer');
define('PURCHASE_FORM_09', 'Angebots-/PI-Nummer');
define('PURCHASE_FORM_10', 'Datei hochladen');
define('PURCHASE_FORM_11', 'Anmerkung');
define('PURCHASE_FORM_12', 'Abschicken');
define('PURCHASE_FORM_13', 'Datei wählen');

define('PURCHASE_FORM_TIP_01', 'Geben Sie bitte Ihre Auftragsnummer ein.');
define('PURCHASE_FORM_TIP_02', 'Wenn Sie ein offizielles Angebot von FS erhalten haben, können Sie die betreffende Informationen wie RQC2001020006 / RQ2001300199 / FS20200128000 hinterlassen.');
define('PURCHASE_FORM_TIP_03', 'Wenn Sie ein offizielles Angebot von FS erhalten haben, können Sie verwandte Dateien zusammen mit der Auftragsdatei hochladen.');
define('PURCHASE_FORM_TIP_04', 'Laden Sie bitte die Auftragsdatei hoch.');
define('PURCHASE_FORM_TIP_05', 'Hinterlassen Sie Anmerkungen bei Anforderungen an Versand, Verpackung und Produkte (z.B. Blind-Shipment und maßgeschneiderte Produkte).');
define('PURCHASE_FORM_TIP_06', 'Die Anmerkung darf maximal 500 Zeichen lang sein.');

define('PURCHASE_FORM_TIP_07', 'Ihr Beschaffungsauftrag wurde erfolgreich abgeschickt.');
define('PURCHASE_FORM_TIP_08', 'Wir werden den Auftrag innerhalb von 12 bis 24 Stunden bearbeiten. Sie können auch die Aktualisierung des Status unter „<a href="'.zen_href_link('purchase_order_list').'">Meine Beschaffungsaufträge</a>“ finden.');

define('PURCHASE_LIST_01','Neuer Beschaffungsauftrag');
define('PURCHASE_LIST_02','Alle Beschaffungsaufträge');
define('PURCHASE_LIST_03','Auftragsnummer');
define('PURCHASE_LIST_04','Erstellungsdatum');
define('PURCHASE_LIST_05','Status');
define('PURCHASE_LIST_06','Bestellnummer');
define('PURCHASE_LIST_07','Abgeschickt');
define('PURCHASE_LIST_07_TIP','Nachstehend finden Sie die Informationen zum Beschaffungsauftrag. Wir werden Ihnen innerhalb von 12 bis 24 Stunden antworten.');
define('PURCHASE_LIST_08','Genehmigt');
define('PURCHASE_LIST_08_TIP','Ihr Beschaffungsauftrag ist genehmigt. Wir arbeiten derzeit daran, eine Bestellung für Sie zu erstellen.');
define('PURCHASE_LIST_09','Bestellung erstellt');
define('PURCHASE_LIST_09_TIP','Ihre Bestellung wurde erfolgreich erstellt. Klicken Sie auf „Jetzt bezahlen“, um die Zahlung abzuschließen. Und Sie können auf die Bestellnummer FSXXX klicken, um mehr Bestelldetails zu sehen.');
define('PURCHASE_LIST_09_TIP1','Ihre Bestellung wurde erfolgreich erstellt und wird derzeit bearbeitet. Sie können auf die Bestellnummer FSXXX klicken, um mehr Bestelldetails zu sehen.');
define('PURCHASE_LIST_EMPTY_01','Sie haben noch keine Beschaffungsaufträge.');
define('PURCHASE_LIST_EMPTY_02','Kein Ergebnis');
define('PURCHASE_LIST_FORM_01','Zur schnellen Bearbeitung Ihres Auftrags stellen Sie bitte sicher, dass alle erforderlichen Informationen enthalten sind.');
define('PURCHASE_LIST_FORM_02','Auftragsnummer');
define('PURCHASE_LIST_FORM_03','z.B. RQC2001020006');
define('PURCHASE_LIST_FORM_04','Hinterlassen Sie Anmerkungen bei Anforderungen an Versand, Verpackung und Produkte (z.B. Blind-Shipment und maßgeschneiderte Produkte).');

define('PURCHASE_PO_DETAILS','Details zum Beschaffungsauftrag');
define('PURCHASE_PO_DETAILS_DATE','Auftragsdatum:');
define('PURCHASE_PO_DETAILS_QT','Angebotsnummer:');
define('PURCHASE_PO_DETAILS_REQUEST','Auftragsanforderung');
define('PURCHASE_PO_DETAILS_FILES','Datei:');

//邮件
define('PURCHASE_EMAIL_REVIEWING','Beschaffungsauftrag');
define('PURCHASE_EMAIL_TITLE','FS - Ihr Beschaffungsauftrag #POXXX wird derzeit überprüft');
define('PURCHASE_EMAIL_CONTENT_01','Wir haben Ihren Beschaffungsauftrag #POXXX erhalten und werden ihn innerhalb von 12 bis 24 Stunden bearbeiten.');
define('PURCHASE_EMAIL_CONTENT_02','Sie können sich anmelden und den Auftragsstatus auf der Seite <a href="'.zen_href_link('purchase_order_list').'" target="_blank" style="color: #0070bc;text-decoration: none;">Meine Beschaffungsaufträge</a> in Mein Konto verfolgen.');

define('PURCHASE_PROCESS_TIP','Melden Sie sich an oder erstellen Sie ein Konto, um die Auftragsdatei einzureichen und rechtzeitig online den Status zu verfolgen.');
define('PURCHASE_PROCESS_TITLE','Wie läuft der Beschaffungsauftrag ab?');
define('PURCHASE_PROCESS_01','Einreichen eines Auftrags');
define('PURCHASE_PROCESS_01_TIP','Reichen Sie die Auftragsdatei (PO-Datei) ein.');
define('PURCHASE_PROCESS_02','Bearbeitung des Auftrags');
define('PURCHASE_PROCESS_02_TIP','Wir erstellen nach der Genehmigung eine Online-Bestellung.');
define('PURCHASE_PROCESS_03','Zahlung und Lieferung');
define('PURCHASE_PROCESS_04','Sobald die Bestellung erstellt wurde, schließen Sie bitte die Zahlung online für weitere Bearbeitung und Lieferung ab. Bei einem Kreditkonto wird die Bestellung direkt nach der Genehmigung der Bestellung bearbeitet und vor Zahlungseingang versandt.');
define('PURCHASE_PROCESS_05','Den Bestellstatus verfolgen Sie unter „<a href="'.zen_href_link('manage_orders').'" class="alone_a">Meine Bestellungen</a>“.');