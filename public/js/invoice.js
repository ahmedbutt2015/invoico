const form = document.getElementById('invoice');
const number = document.getElementById('invoice__number');
const submit = document.getElementById('invoice__submit');
const cancelSubmit = document.getElementById('invoice__cancelSubmit');
const description = document.getElementById('invoice__description');
const dateIssued = document.getElementById('invoice__dateIssued');
const dateDue = document.getElementById('invoice__dateDue');
const notes = document.getElementById('invoice__notes');
const currency = document.getElementById('invoice__currency');
const stripeEnabled = document.getElementById('invoice__stripeEnabled');
const detailsArea = document.getElementById('invoice__details');
const buttonsArea = document.getElementById('invoice__buttons');

function enableSavePrompt() {
	window.onbeforeunload = function() { return true; };
	// submit.readonly = false;
	// detailsArea.classList.add('invoice__details--disabled');
	buttonsArea.classList.add('invoice__details--disabled');
	cancelSubmit.classList.add('invoice__cancelSubmit--enabled');
	if(number)
	number.classList.add('noclick');
}

function disableSavePrompt() {
	window.onbeforeunload = null;
	// submit.readonly = true;
	// detailsArea.classList.remove('invoice__details--disabled');
	// buttonsArea.classList.remove('invoice__details--disabled');
	// cancelSubmit.classList.remove('invoice__cancelSubmit--enabled');
	// number.classList.remove('noclick');
	return true;
}

form.addEventListener('submit', disableSavePrompt);
cancelSubmit.addEventListener('click', disableSavePrompt);
description.addEventListener('input', enableSavePrompt);
dateIssued.addEventListener('input', enableSavePrompt);
dateDue.addEventListener('input', enableSavePrompt);
notes.addEventListener('input', enableSavePrompt);
currency.addEventListener('input', enableSavePrompt);
if(stripeEnabled) stripeEnabled.addEventListener('input', enableSavePrompt);

// submit.readonly = true;

function cx(obj) {
	let out = '';
	for(const k in obj) {
		if(obj[k]) out += k + ' ';
	}
	return out;
}

// Dates
function compareDates() {
	if(!dateDue.value || !dateDue.value.length || !dateIssued.checkValidity() || !dateDue.checkValidity()) {
		dateDue.setCustomValidity('');
		return;
	}

	const issued = new Date(dateIssued.value);
	const due = new Date(dateDue.value);

	if(due < issued) {
		dateDue.setCustomValidity('Due date cannot be before the issued date.');
	} else {
		dateDue.setCustomValidity('');
	}
}

function adjustDueDate() {
	const issued = new Date(dateIssued.value);
	issued.setDate(issued.getDate() + defaultDueDays);
	dateDue.value = issued.toJSON().split('T')[0];
	dateDue.classList.add('input--autoUpdateAnimate');
	setTimeout(function() {
		dateDue.classList.remove('input--autoUpdateAnimate');
	}, 1000);
}

if(defaultDueDays != null) {
	dateIssued.addEventListener('change', adjustDueDate);
}

dateIssued.addEventListener('change', compareDates);
dateDue.addEventListener('change', compareDates)

// Expenses

const expensesRoot = document.getElementById('expenses');

const quantityScale = 1e3;
const currencyScale = +('1e'+currencyData.precision);

function expenseTotal(expense) {
	const total = Math.round(expense.value * currencyScale) * Math.round(expense.quantity * quantityScale);
	return Math.floor(total / quantityScale);
}

function transformInputValues(event) {

	form.classList.add('invoice--hideInputs');

	// Modify expense input values to smallest denomination before submitting
	if(currencyData.precision != 0) {
		const valueEls = document.querySelectorAll('input[type="number"][name="exp_val"]');
		valueEls.forEach(function(el) {
			el.value = Math.round(el.value * currencyScale);
		});
	}

	// Modify expense and tax quantities
	const quanEls = document.querySelectorAll('input[name="exp_quan"], input[name="tax1percent"], input[name="tax2percent"]');
	quanEls.forEach(function(el) {
		el.value = Math.round(el.value);
	});

	return true;
}
form.addEventListener('submit', transformInputValues);

// Format expense values from server to include fractional parts
function transformExpenseFromFullCurrencyUnit(e) {
	if(currencyData.precision == 0) return e;

	return {
		description: e.description,
		quantity: e.quantity ,
		value: e.value ,
	};
}

const fSep = String.fromCharCode(formatData.fSep);
const gSep = String.fromCharCode(formatData.gSep);
function formatCurrency(value, precision) {
	const num = Number(value);
	if(isNaN(num)) {
		return value;
	}
	let f;
	if(precision == null) {
		f = num.toString();
	} else {
		f = num.toFixed(precision);
	}
	let whole = f;
	let fract = '';
	const neg = whole.indexOf('-') != -1;

	if(neg) {
		whole = whole.replace('-', '');
	}
	let fraction = false;
	if(precision != 0 && whole.indexOf('.') != -1) {
		fraction = true;
		const parts = whole.split('.');
		whole = parts[0];
		fract = parts[1];
	}
	if(formatData.gLen > 0) {
		let newWhole = '';
		for(let i = 0; i < whole.length; i++) {
			if(i > 0 && (whole.length - i) % formatData.gLen == 0) {
				newWhole += gSep;
			}
			newWhole += whole[i];
		}
		whole = newWhole;
	}

	let output = whole;
	if(fraction) {
		output = output + fSep + fract;
	}

	if(neg) {
		if(formatData.negDisplay == 0) {
			output = '-' + output;
		} else if(formatData.negDisplay == 1) {
			output = '(' + output + ')';
		} else if(formatData.negDisplay == 2) {
			output = output + '-';
		}
	}
	return output;
}

const Expense = {
	// State
	dragged: false,
	yOffset: 0,
	initialDragMouse: null,
	currentDragMouse: null,
	parentDOMHeight: null,

	handleDragMouseDown: function(e) {
		this.state.dragged = true;
		this.yOffset = 0;

		this.state.parentDOMHeight = this.dom.parentNode.offsetHeight;

		this.handler_windowMouseMove = this.tag.handleDragMouseMove.bind(this);
		this.handler_windowMouseUp = this.tag.handleDragMouseUp.bind(this);
		window.addEventListener('mousemove', this.handler_windowMouseMove);
		window.addEventListener('mouseup', this.handler_windowMouseUp);
		this.state.initialDragMouse = e.clientY;
		this.state.currentDragMouse = e.clientY;
	},
	handleDragMouseMove: function(e) {
		this.state.currentDragMouse = e.clientY;

		let diff = this.state.currentDragMouse - this.state.initialDragMouse;
		const min = -this.attrs.index * this.dom.offsetHeight;
		const max = this.state.parentDOMHeight - this.dom.offsetHeight * (this.attrs.index + 1);
		this.state.yOffset = (diff < min) ? min : ((diff > max) ? max : diff);

		const halfHeight = this.dom.offsetHeight / 2;
		const midpoint = this.dom.offsetTop + halfHeight;

		this.newIndex = Math.min(this.attrs.expensesCount-1, Math.max(0, Math.round((this.dom.offsetTop) / this.dom.offsetHeight)));

		m.redraw();
	},
	handleDragMouseUp: function(e) {
		this.state.dragged = false;
		this.state.yOffset = 0;
		this.attrs.move(this.attrs.index, this.newIndex);
		delete this.newIndex;

		m.redraw();

		window.removeEventListener('mousemove', this.handler_windowMouseMove);
		window.removeEventListener('mouseup', this.handler_windowMouseUp);
		this.handler_windowMouseMove = null;
		this.handler_windowMouseUp = null;
	},
	handleDescriptionChange: function(e) {
		this.attrs.expense.description = e.target.value;
		enableSavePrompt();
	},
	handleQuantityChange: function(e) {
		// Limit to 3 decimal places
		this.attrs.expense.quantity = e.target.value;
		enableSavePrompt();
	},
	handleQuantityBlur: function(e) {
		this.attrs.expense.quantity = Math.round(this.attrs.expense.quantity * quantityScale) / quantityScale;
	},
	handleValueChange: function(e) {
		this.attrs.expense.value = e.target.value;
		enableSavePrompt();
	},
	handleValueBlur: function(e) {
		this.attrs.expense.value = Math.round(this.attrs.expense.value * currencyScale) / currencyScale;
	},
	handleTotalFocus: function(e) {
		e.target.value = expenseTotal(this.attrs.expense) / currencyScale;
	},
	handleTotalChange: function(e) {
		this.attrs.expense.value = Math.round(e.target.value * currencyScale) / currencyScale;
		this.attrs.expense.quantity = 1;
		enableSavePrompt();
	},
	view: function(vnode) {
		const style = {};
		if(vnode.state.dragged) {
			style.top = vnode.state.yOffset + 'px';
		}

		return m('li', {class: cx({'expense': true, 'expense--dragged': vnode.state.dragged}), style}, [
			m('div', {class: 'display--table-row'}, [
				m('span', {class: 'expense__drag', onmousedown: this.handleDragMouseDown.bind(vnode)}, '\u2261'),

				m('span', {class: 'expense__colDesc left display--table-cell p-v-md'}, [
					m('input', {type: 'text', maxlength: 255, name: 'exp_desc[]', value: vnode.attrs.expense.description, placeholder: 'Description', class: 'fullWidth left', oninput: vnode.tag.handleDescriptionChange.bind(vnode), onkeypress: disableEnterSubmit, autocomplete: 'off'}),
				]),

				m('span', {class: 'expense__colQty display--table-cell font-mono right p-v-md'}, [
					m('input', {type: 'number', inputmode: 'numeric', step: 'any', max: 99999999, min: 0, name: 'exp_quan[]', value: vnode.attrs.expense.quantity, class: 'expense__input font-mono right', oninput: vnode.tag.handleQuantityChange.bind(vnode), onblur: vnode.tag.handleQuantityBlur.bind(vnode), onkeypress: disableEnterSubmit, autocomplete: 'off'}),
					m('span', {class: 'expense__preview font-mono right'}, formatCurrency(vnode.attrs.expense.quantity, null)),
				]),
				m('span', {class: 'expense__colPrice display--table-cell font-mono right p-v-md'}, [
					m('input', {type: 'number', inputmode: 'numeric', step: currencyData.step, max: 99999999, min: -99999999, name: 'exp_val[]', value: vnode.attrs.expense.value, class: 'expense__input font-mono right', oninput: vnode.tag.handleValueChange.bind(vnode), onblur: vnode.tag.handleValueBlur.bind(vnode), onkeypress: disableEnterSubmit, autocomplete: 'off'}),
					m('span', {class: 'expense__preview font-mono right'}, formatCurrency(vnode.attrs.expense.value, currencyData.precision)),
				]),
				m('span', {class: 'expense__colTotal display--table-cell font-mono right p-v-md'}, [
					m('input', {type: 'number', inputmode: 'numeric', step: currencyData.step, max: 99999999, min: -99999999, class: 'expense__input font-mono right', oninput: vnode.tag.handleTotalChange.bind(vnode), onfocus: vnode.tag.handleTotalFocus.bind(vnode), onkeypress: disableEnterSubmit, autocomplete: 'off'}),
					m('span', {class: 'expense__preview font-mono right'}, formatCurrency(expenseTotal(vnode.attrs.expense) / currencyScale, currencyData.precision)),
				]),

				m('span', {class: 'expense__delete', onclick: function() { vnode.attrs.delete(vnode.attrs.index); }}, '\xD7'),
			]),

			m('div', {class: 'expense__buttons m-v-sm'},
				m('div', {class: 'flex'}, [
					m('span', {class: 'expense__button m-r-md', onclick: function() { vnode.attrs.move(vnode.attrs.index, vnode.attrs.index - 1); }}, '↑'),
					m('span', {class: 'expense__button', onclick: function() { vnode.attrs.move(vnode.attrs.index, vnode.attrs.index + 1); }}, '↓'),
					m('span', {class: 'flex__grow'}),
					m('span', {class: 'expense__button', onclick: function() { vnode.attrs.delete(vnode.attrs.index); }}, '×'),
				])
			)
		]);
	}
};

const Expenses = {

	expenses: null,
	tax1percent: tax1Data.percent ,
	tax1description: tax1Data.description,
	tax1enabled: tax1Data.percent != null,
	tax2percent: tax2Data.percent / 1000,
	tax2description: tax2Data.description,
	tax2enabled: tax2Data.percent != null,

	oninit: function(vnode) {
		vnode.state.expenses = expenseData.map(function(e) {
			return Object.assign({}, transformExpenseFromFullCurrencyUnit(e));
		});

		form.addEventListener('reset', function() {
			vnode.state.expenses = expenseData.map(function(e) {
				return Object.assign({}, transformExpenseFromFullCurrencyUnit(e));
			});
			vnode.state.tax1percent = tax1Data.percent ;
			vnode.state.tax1description = tax1Data.description;
			vnode.state.tax1enabled = tax1Data.percent != null;
			vnode.state.tax2percent = tax2Data.percent / 1000;
			vnode.state.tax2description = tax2Data.description;
			vnode.state.tax2enabled = tax2Data.percent != null;
			setTimeout(m.redraw, 0);
		});
	},

	createExpense: function() {
		this.state.expenses.push({description: '', quantity: 1, value: 0});
		// enableSavePrompt();
		// Focus the input
		setTimeout(function() {
			try {
				this.dom.lastChild.children[1].firstChild.focus();
			} catch(e) {}
		}.bind(this), 0);
	},
	deleteExpense: function(index) {
		this.state.expenses.splice(index, 1);
		enableSavePrompt();
	},
	moveExpense: function(from, to) {
		this.state.expenses.splice(to, 0, this.state.expenses.splice(from, 1)[0]);
		enableSavePrompt();
	},
	handleTax1Toggle: function(event) {
		this.state.tax1enabled = event.target.checked;
		enableSavePrompt();
	},
	handleTax1DescriptionChange: function(event) {
		this.state.tax1description = event.target.value;
		enableSavePrompt();
	},
	handleTax1PercentChange: function(event) {
		this.state.tax1percent = event.target.value;
		enableSavePrompt();
	},
	handleTax2Toggle: function(event) {
		this.state.tax2enabled = event.target.checked;
		enableSavePrompt();
	},
	handleTax2DescriptionChange: function(event) {
		this.state.tax2description = event.target.value;
		enableSavePrompt();
	},
	handleTax2PercentChange: function(event) {
		this.state.tax2percent = event.target.value;
		enableSavePrompt();
	},

	view: function(vnode) {

		const subtotal = vnode.state.expenses.reduce(function(total, expense) {
			return total + expenseTotal(expense, currencyData.precision);
		}, 0);
		const tax1 = vnode.state.tax1percent && vnode.state.tax1enabled ? Math.floor(vnode.state.tax1percent / 100 * subtotal) : 0;
		const tax2 = vnode.state.tax2percent && vnode.state.tax2enabled ? Math.floor(vnode.state.tax2percent / 100 * subtotal) : 0;
		const total = subtotal + tax1 + tax2;

		return [
			m('ul', {class: 'invoice__expenses display--table fullWidth fullWidth--max m-b-sm'},
				vnode.state.expenses.map(function(expense, index) {
					return m(Expense, {
						expense,
						index,
						expensesCount: vnode.state.expenses.length,
						create: vnode.tag.createExpense.bind(vnode),
						move: vnode.tag.moveExpense.bind(vnode),
						delete: vnode.tag.deleteExpense.bind(vnode),
					});
				})
			),
			m('div', [
				m('span', {class: 'display--inline-block m-t-md'}, [
					m('button', {class: 'pointer stylelessButton', type: 'button', onclick: vnode.tag.createExpense.bind(vnode)}, m('img', {src: 'img/icon_add.svg'})),
				]),
				m('table', {class: 'right float-right m-v-md'}, m('tbody', [
					m('tr', [
						m('td', {class: 'gray p-r-md p-v-sm'}, 'Subtotal'),
						m('td', {class: 'font-mono blue p-v-sm'}, formatCurrency(subtotal / currencyScale, currencyData.precision))
					]),
					m('tr', [
						m('td', {class: 'p-r-md flex flex--baseline flex--center flex--justify-end'}, [
							m('input', {type: 'checkbox', id: 'tax1enabled', class: 'visibility--hidden', checked: vnode.state.tax1enabled, onchange: vnode.tag.handleTax1Toggle.bind(vnode)}),
							m('label', {class: 'gray', for: 'tax1enabled', class: 'tax__label label--check label--check-gray-unselected gray p-v-sm', style: 'border: 1px solid transparent;'}, 'TAX(VAT)'),
							vnode.state.tax1enabled ? m('input', {type: 'text', placeholder: 'Description', name: 'tax1description', value: vnode.state.tax1description, maxlength: 255, autocomplete: 'off', class: 'inputBorder right p-sm m-h-sm', style: 'max-width: 80px', oninput: vnode.tag.handleTax1DescriptionChange.bind(vnode)}) : null,
							vnode.state.tax1enabled ? m('span', {class: 'inputBorder ws-nowrap p-sm m-h-sm'}, m('input', {type: 'number', inputmode: 'numeric', step: '0.001', name: 'tax1percent', value: vnode.state.tax1percent, max: 99999, min: -99999, autocomplete: 'off', class: 'right', style: 'max-width: 40px', oninput: vnode.tag.handleTax1PercentChange.bind(vnode)}), m('span', '%')) : null,
						]),
						m('td', {class: 'font-mono blue'}, formatCurrency(tax1 / currencyScale, currencyData.precision))
					]),
					m('tr', [
						m('td', {class: 'gray p-r-md p-v-sm'}, 'Total'),
						m('td',{style: 'display:none;'}, [m('input',{class: 'font-mono blue p-v-sm totalInvoice',readonly:true,type: 'hidden',  step: '0.001', name: 'total_val', value: (total / currencyScale)})] ),
						m('td', [m('input',{class: 'font-mono blue p-v-sm totalInvoice',readonly:true,type: 'text',  step: '0.001', name: 'total', value: formatCurrency(total / currencyScale, currencyData.precision)})] )
					])
				]))
			])
		];
	}
};

m.mount(expensesRoot, Expenses);
