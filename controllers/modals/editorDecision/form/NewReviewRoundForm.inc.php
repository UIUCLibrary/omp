<?php

/**
 * @file controllers/modals/editorDecision/form/NewReviewRoundForm.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class NewReviewRoundForm
 * @ingroup controllers_modal_editorDecision_form
 *
 * @brief Form for creating a new review round (after the first)
 */

import('lib.pkp.classes.controllers.modals.editorDecision.form.EditorDecisionForm');
import('classes.monograph.reviewRound.ReviewRound');

class NewReviewRoundForm extends EditorDecisionForm {

	/**
	 * Constructor.
	 * @param $submission Submission
	 * @param $decision int
	 * @param stageid int
	 */
	function NewReviewRoundForm($submission, $decision = SUBMISSION_EDITOR_DECISION_RESUBMIT, $stageId = null, $reviewRound) {
		parent::EditorDecisionForm($submission, $decision, $stageId, 'controllers/modals/editorDecision/form/newReviewRoundForm.tpl', $reviewRound);
		// WARNING: this constructor may be invoked dynamically by
		// EditorDecisionHandler::_instantiateEditorDecision.
	}


	//
	// Implement protected template methods from Form
	//
	/**
	 * @see Form::execute()
	 * @return integer The new review round number
	 */
	function execute($args, $request) {
		// Retrieve the submission.
		$submission = $this->getSubmission();

		// Get this form decision actions labels.
		$actionLabels = EditorDecisionActionsManager::getActionLabels($this->_getDecisions());

		// Record the decision.
		$reviewRound = $this->getReviewRound();
		import('classes.submission.seriesEditor.SeriesEditorAction');
		$seriesEditorAction = new SeriesEditorAction();
		$seriesEditorAction->recordDecision($request, $submission, SUBMISSION_EDITOR_DECISION_RESUBMIT, $actionLabels, $reviewRound);

		// Update the review round status.
		$reviewRoundDao = DAORegistry::getDAO('ReviewRoundDAO');
		$reviewRoundDao->updateStatus($reviewRound, null, REVIEW_ROUND_STATUS_RESUBMITTED);

		// Create a new review round.
		$newRound = $this->_initiateReviewRound(
			$submission, $submission->getStageId(),
			$request, REVIEW_ROUND_STATUS_PENDING_REVIEWERS
		);

		return $newRound;
	}

	//
	// Private functions
	//
	/**
	 * Get this form decisions.
	 * @return array
	 */
	function _getDecisions() {
		return array(
			SUBMISSION_EDITOR_DECISION_RESUBMIT
		);
	}
}

?>
