/* ----------------------------
		Requires jQuery
---------------------------- */

$(document).ready(function(){
	$('input,textarea').keypress(function(){
		try{
			this.form.elements.pv.value='verified';
		} catch(e){}
	});
	
	$('input[required], textarea[required], select[required]').each(function(){
		//disable built-in HTML handling of required attribute b/c not consistent at this point
		$(this).removeAttr('required').attr('req',true);
	});
	
	// Handle max words on textareas
	$('textarea[maxwords]').keypress(function(e){
		$(this).parent().removeClass('validation_warning');
		$('p.warning',$(this).parent()).remove();
		words = this.value.split(' ').length;
		if (e.which !== 8) {
			maxWords = $(this).attr('maxwords');
			if (words > maxWords) {
				addWarning(this,"Please limit your input to "+maxWords+" words.");
				return false;
			}
		}
		$('#words').html(words);
	});
	
	$('textarea[maxwords]').keyup(function() {
		$(this).parent().removeClass('validation_warning');
		$('p.warning',$(this).parent()).remove();
		words = this.value.split(' ');
		num_words = words.length;
		maxWords = $(this).attr('maxwords');
		if (num_words > maxWords) {
			addWarning(this,"Please limit your input to "+maxWords+" words.");
			strTruncated = '';
			for (i=0; i<maxWords; i++) {
				strTruncated = strTruncated + words[i] + ' ';
			}
			this.value = strTruncated;
		}
	});
});

function removeWarnings(f) {
	$('p.warning',f).remove();
	$('.validation_warning',f).removeClass('validation_warning');
}

function fnValidate(f) {
	try {
		//Get rid of existing warnings
		removeWarnings(f);
		top.strFirstFailure = '';
		top.bValid = true;
		
		//validate all fields except radio & checkbox
		$('textarea,select,input:not(:radio,:checkbox)',f).each(function(){
			jEl = $(this);
			strValue = $.trim(jEl.val());
			strName = jEl.attr('name');
			bRequired = jEl.attr('req');
			strValidationType = jEl.attr('validationtype');
			if (bRequired && strValue=='') {
				// item is required but blank
				addWarning(this);
				top.bValid = false;
				if (top.strFirstFailure == '') top.strFirstFailure = strName;
			} else {
				// check validation type if specified
				switch (strValidationType) {
					case 'email':
						if (!isValidEmail(strValue)) {
							addWarning(this,'E-mail must be a valid address in the format <em>user@website.com</em>');
							top.bValid = false;
							if (top.strFirstFailure == '') top.strFirstFailure = strName;
						}
						break;
					case 'number':
						if (!isNumeric(strValue)) {
							addWarning(this);
							top.bValid = false;
							if (top.strFirstFailure == '') top.strFirstFailure = strName;
						}
						break;
				} //switch
			} // else
		});
		
		//validate radio & checkbox
		var arValidatedInputGroups = [];
		$(':radio,:checkbox',f).each(function(){
			jEl = $(this);
			strName = jEl.attr('name');
			bRequired = jEl.attr('required')=='required';
			if (bRequired && arValidatedInputGroups[strName] != true) {
				strValue = '';
				$("INPUT[name='"+strName+"']:checked",f).each(function(){
					strValue += this.value;
				});
				if ($.trim(strValue) == ''){
					addWarning(this);
					top.bValid = false;
					if (top.strFirstFailure == '') top.strFirstFailure = strName;
				}
				arValidatedInputGroups[strName] = true;
			}
		});
		
		if (!top.bValid) eval('f.'+top.strFirstFailure+'.focus()');
		return top.bValid;
	} catch(e) {
		alert('Error: '+e.name+'\n'+e.description);
		return false;
	}
}

function isNumeric(val) {
	var ValidChars = "0123456789.-()";
	for (i=0; i<val.length; i++) if (ValidChars.indexOf(val.charAt(i)) == -1) return false;
	return true;
}

function isValidEmail(val) {
	var iLen = val.length;
	if 	((iLen < 6) || (val.indexOf('@') < 1) || ((val.charAt(iLen - 3) != '.') && (val.charAt(iLen - 4) != '.') && (val.charAt(iLen - 5) != '.')) ) return false;
	return true;
}

function addWarning(oInput, strWarning){
	jEl = $(oInput);
	if (!strWarning || strWarning.length < 1) {
	  if (oInput.title.length < 1) {
	    strWarning = "A valid "+oInput.name+" is required.";
	  } else {
	    strWarning = oInput.title;
	  }
	}
	if (jEl.is(':radio,:checkbox') && jEl.parent().get(0).tagName == 'FIELDSET') {
		jEl.parent().addClass('validation_warning').after('<p class="warning">'+strWarning+'</p>');
	} else {
		jEl.addClass('validation_warning').after('<p class="warning">'+strWarning+'</p>');
	}
	
}