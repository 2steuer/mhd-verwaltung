<?php

class SendEmailController extends Controller {
    public static $allowed_actions = array('notify' => '->checkPermission');
	
	function checkPermission() {
		return (Director::is_cli() || Permission::check('ADMIN'));
	}

	public function notify($request) {
		$members = Member::get();
		$count = 0;

		foreach($members as $member) {
			$start = microtime(true);

            print("Member: " .$member->FirstName." ".$member->Surname ."\n");

			$checklist = array(1=>new ArrayList(), 2=>new ArrayList());
			foreach($member->SubscribedCategories() as $category) {
				print("\tCategory: ".$category->Name."\n");

				foreach($category->Devices()->filter(array('Active' => '1')) as $device) {
                    print("\t\tDevice: " . $device->Name."\n");

					foreach($device->Checks()->filter(array('Active' => '1')) as $check) {
						$level = $check->CheckAlert();

                        print("\t\t\tCheck: " . $check->TypeName() . " (".$level.")");

						if($level > 0) {

                            print("\tDevice " . $device->Name . " - " . $level . "\n");

							if(!$this->wasAlreadySent($member->ID, $check->ID, $level)) {
								print("\t\t\tNot sent jet...\n");
                                $checklist[$level]->add($check);
								$this->addSendNotification($member->ID, $check->ID, $level);
							}
                            else {
                                print("\t\tAlready sent.\n");
                            }
						}
					}
				}
			}

			if($checklist[1]->count() > 0 || $checklist[2]->count() > 0) {

				$mail = new Email("noreply@malteser-stormarn.de", $member->Email, "[Geräteprüfung] Anstehende Prüfungen!");
				$mail->setTemplate('NotificationEmail');
				$mail->populateTemplate(array(
						'Member' => $member,
						'UrgentChecks' => $checklist[2],
						'OtherChecks' => $checklist[1]
					)
				);

				$mail->send();
				$count++;

				print("\nEmail to ".$member->ID." ".$member->FirstName . " ". $member->Surname."\n\n\n");
			}
		}

		print($count." sent in ".number_format((microtime(true) - $start), 4)."s");
	}

	function addSendNotification($memberID, $checkID, $alertLevel) {
		$not = new NotificationNote();
		$not->MemberID = $memberID;
		$not->CheckID = $checkID;
		$not->Level = $alertLevel;

		$not->write();
	}

	function wasAlreadySent($memberID, $checkID, $alertLevel) {
		$result = NotificationNote::get()->filter(
			array(
				'CheckID' => $checkID,
				'MemberID' => $memberID,
				'Level' => $alertLevel
			)
		);

		if($result->count() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
}