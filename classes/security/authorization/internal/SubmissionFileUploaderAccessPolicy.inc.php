<?php

/**
 * @file classes/security/authorization/internal/SubmissionFileUploaderAccessPolicy.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmissionFileUploaderAccessPolicy
 * @ingroup security_authorization_internal
 *
 * @brief Submission file policy to check if the current user is the uploader.
 *
 */

import('lib.pkp.classes.security.authorization.internal.SubmissionFileBaseAccessPolicy');

class SubmissionFileUploaderAccessPolicy extends SubmissionFileBaseAccessPolicy {
	/**
	 * Constructor
	 * @param $request PKPRequest
	 */
	function SubmissionFileUploaderAccessPolicy($request, $fileIdAndRevision = null) {
		parent::SubmissionFileBaseAccessPolicy($request, $fileIdAndRevision);
	}


	//
	// Implement template methods from AuthorizationPolicy
	//
	/**
	 * @see AuthorizationPolicy::effect()
	 */
	function effect() {
		$request = $this->getRequest();

		// Get the user
		$user = $request->getUser();
		if (!is_a($user, 'PKPUser')) return AUTHORIZATION_DENY;

		// Get the submission file
		$submissionFile = $this->getSubmissionFile($request);
		if (!is_a($submissionFile, 'SubmissionFile')) return AUTHORIZATION_DENY;

		// Check if the uploader is the current user.
		if ($submissionFile->getUploaderUserId() == $user->getId()) {
			return AUTHORIZATION_PERMIT;
		} else {
			return AUTHORIZATION_DENY;
		}
	}
}

?>
