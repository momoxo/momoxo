<?php

/**
 * Lenum_GroupRank
**/
class Lenum_GroupRank
{
	const GUEST = 0;
	const ASSOCIATE = 2;
	const REGULAR = 5;
	const STAFF = 7;
	const OWNER = 9;

	public static function getList()
	{
		return array(
			self::GUEST => _GROUP_RANK_GUEST,
			self::ASSOCIATE => _GROUP_RANK_ASSOCIATE,
			self::REGULAR => _GROUP_RANK_REGULAR,
			self::STAFF => _GROUP_RANK_STAFF,
			self::OWNER => _GROUP_RANK_OWNER
		);
	}
}
