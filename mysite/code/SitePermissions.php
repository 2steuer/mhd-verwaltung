<?php

class SitePermissions implements PermissionProvider  {

	public function providePermissions() {
		return array(
				'PERM_PRUEFDATEN' => 'Zugriff auf die Prüfdaten',
				'PERM_DEVICELIST' => 'Zugriff auf die VDE-Geräteliste'
			);
	}
}