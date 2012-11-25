<?php

/**
 * Lenum_WorkflowStatus
**/
interface Lenum_WorkflowStatus
{
	const DELETED = 0;
	const BLOCKED = 1;
	const REJECTED = 2;
	const PROGRESS = 5;
	const FINISHED = 9;
}
