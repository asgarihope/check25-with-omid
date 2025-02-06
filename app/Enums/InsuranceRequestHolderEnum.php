<?php

namespace App\Enums;

enum InsuranceRequestHolderEnum: string {

	case CONDUCTOR_PRINCIPAL = 'CONDUCTOR_PRINCIPAL';
	case SECONDARY_DRIVER = 'SECONDARY_DRIVER';
	case THIRD_PARTY = 'THIRD_PARTY';
	case AGENT = 'AGENT';
}
