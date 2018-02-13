<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block\Adminhtml\Widget\Chooser;

class Ids extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Checkbox {
	public function render(\Magento\Framework\DataObject $row){
		$values = $this->getColumn()->getValues();
		$value = $row->getData($this->getColumn()->getIndex());
		$checked = '';
		if (is_array($values)) {
			$checked = in_array($value, $values) ? ' checked="checked"' : '';
		} else {
			$checkedValue = $this->getColumn()->getValue();
			if ($checkedValue !== null) {
				$checked = $value === $checkedValue ? ' checked="checked"' : '';
			}
		}
		$disabled = '';
		$disabledValues = $this->getColumn()->getDisabledValues();
		if (is_array($disabledValues)) {
			$disabled = in_array($value, $disabledValues) ? ' disabled="disabled"' : '';
		} else {
			$disabledValue = $this->getColumn()->getDisabledValue();
			if ($disabledValue !== null) {
				$disabled = $value === $disabledValue ? ' disabled="disabled"' : '';
			}
		}
		$this->setDisabled($disabled);
		if ($this->getNoObjectId() || $this->getColumn()->getUseIndex()) {
			$v = $value;
		} else {
			$v = $row->getId() != "" ? $row->getId() : $value;
		}
		return $this->_getCheckboxHtml($v, $checked);
	}
	protected function _getCheckboxHtml($value, $checked){
		$html = '<label class="data-grid-checkbox-cell-inner" ';
		$html .= ' for="id_' . $this->escapeHtml($value) . '">';
		$html .= '<input type="checkbox" ';
		$html .= 'name="' . $this->getColumn()->getFieldName() . '" ';
		$html .= 'value="' . $this->escapeHtml($value) . '" ';
		$html .= 'id="id_' . $this->escapeHtml($value) . '" ';
		$html .= 'onchange="' . $this->getColumn()->getGrid()->getJsObjectName() . '.checkboxCheckCallback($('.$this->getColumn()->getGrid()->getJsObjectName().'), this)" ';
		$html .= 'class="' .
			($this->getColumn()->getInlineCss() ? $this->getColumn()->getInlineCss() : 'checkbox') .
			' admin__control-checkbox' . '"';
		$html .= $checked . $this->getDisabled() . '/>';
		$html .= '<label for="id_' . $this->escapeHtml($value) . '"></label>';
		$html .= '</label>';
		return $html;
	}
}