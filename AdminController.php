<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 6/24/14
 * Time: 4:25 PM
 */

namespace Plugin\Button;


class AdminController
{

	/**
	 * WidgetSkeleton.js ask to provide widget management popup HTML. This controller does this.
	 * @return \Ip\Response\Json
	 * @throws \Ip\Exception\View
	 */
	public function widgetPopupHtml()
	{
		$widgetId = ipRequest()->getQuery('widgetId');
		$widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
		$widgetData = $widgetRecord['data'];

		//create form prepopulated with current widget data
		$form = $this->managementForm($widgetData);

		//Render form and popup HTML
		$viewData = array(
			'form' => $form
		);
		$popupHtml = ipView('view/editPopup.php', $viewData)->render();
		$data = array(
			'popup' => $popupHtml
		);
		//Return rendered widget management popup HTML in JSON format
		return new \Ip\Response\Json($data);
	}


	/**
	 * Check widget's posted data and return data to be stored or errors to be displayed
	 */
	public function checkForm()
	{
		$data = ipRequest()->getPost();
		$form = $this->managementForm();
		$data = $form->filterValues($data); //filter post data to remove any non form specific items
		$errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3
		if ($errors) {
			//error
			$data = array (
				'status' => 'error',
				'errors' => $errors
			);
		} else {
			//success
			unset($data['aa']);
			unset($data['securityToken']);
			unset($data['antispam']);
			$data = array (
				'status' => 'ok',
				'data' => $data

			);
		}
		return new \Ip\Response\Json($data);
	}

	protected function managementForm($widgetData = array())
	{
		$form = new \Ip\Form();

		$form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

		//setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
		$field = new \Ip\Form\Field\Hidden(
			array(
				'name' => 'aa',
				'value' => 'Button.checkForm'
			)
		);
		$form->addField($field);

		$field = new \Ip\Form\Field\Text(
			array(
				'name' => 'buttonText',
				'label' => __('Text', 'Button'),
				'value' => empty($widgetData['buttonText']) ? null : $widgetData['buttonText']
			));
		$form->addfield($field);

		$field = new \Ip\Form\Field\Text(
			array(
				'name' => 'url',
				'label' => __('URL', 'Button'),
				'value' => empty($widgetData['url']) ? null : $widgetData['url']
			));
		$form->addfield($field);

		$values = array(
			array('button', __('Button', 'Button')),
			array('bigbutton', __('Big Button', 'Button')),
			array('bigbutton2', __('Big Button 2', 'Button')),
			array('facebook', __('Facebook Button', 'Button')),
			array('link', __('Link', 'Button')),
		);

		$field = new \Ip\Form\Field\Select(
			array(
				'name' => 'type',
				'label' => __('Type', 'Button'),
				'values' => $values,
				'value' => empty($widgetData['type']) ? null : $widgetData['type']
			));
		$field->addValidator('Required');
		$form->addfield($field);

		$field = new \Ip\Form\Field\Text(
			array(
				'name' => 'id',
				'label' => __('ID (optional)', 'Button', false),
				'value' => empty($widgetData['id']) ? null : $widgetData['id']
			));
		$form->addfield($field);

		$field = new \Ip\Form\Field\Text(
			array(
				'name' => 'customClass',
				'label' => __('CSS classes (optional)', 'Button', false),
				'value' => empty($widgetData['customClass']) ? null : $widgetData['customClass']
			));
		$form->addfield($field);

		return $form;
	}
}
