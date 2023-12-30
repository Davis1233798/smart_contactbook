import TomSelect from 'tom-select';

export default class extends window.Controller {

    connect() {
        if (document.documentElement.hasAttribute('data-turbo-preview')) {
            return;
        }
        const self = this;
        const element = self.element;
        const select = element.querySelector('select');
        const plugins = ['change_listener'];

        const allowEmpty = self.data.get('allow-empty');
        const lockedOptions = JSON.parse(self.data.get('locked') + '');
        const lockedMessage = self.data.get('locked-message');

        if (select.hasAttribute('multiple')) {
            plugins.push('remove_button');
            if (!lockedOptions.length && !self.data.get('disabled-clear') === 'true') {
                plugins.push('clear_button');
            }
        }

        const choices = new TomSelect(select, {
            create: self.data.get('allow-add') === 'true',
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            preload: true,
            plugins,
            maxItems: select.getAttribute('maximumSelectionLength') || select.hasAttribute('multiple') ? null : 1,
            render: {
                option_create: (data, escape) => `<div class="create">${self.data.get('message-add')} <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () => `<div class="no-results">${self.data.get('message-notfound')}</div>`,
            },
            onDelete: function (values) {
                const intersection = values.filter(value => lockedOptions.includes(value));
                if (intersection.length) {
                    alert(lockedMessage)
                    return false
                }
                return !!allowEmpty
            }
        });

        choices.on('change', function (value) {
            element.dataset.selectExValues = JSON.stringify(value);
            self.dispatch('changed', {
                detail: {
                    selectName: select.name,
                    selectValue: value
                }
            })
        });
        choices.on('item_add', function (value, data) {
            element.dataset.selectExValues = JSON.stringify(choices.getValue());
        });

        self.choices = choices;

        self.resetValue(self.data.get('values'));

        if (self.data.get('readonly') === 'true') {
            self.choices.lock()
        }
    }

    filterOptions(evt) {
        const self = this;
        const choices = self.choices;
        const element = self.element;
        const select = element.querySelector('select');

        if (evt.detail.selectName === '#' + select.name) {
            const filterOptions = JSON.parse(self.data.get('choices') + '');
            choices.clear();
            choices.clearOptions();
            Object.entries(filterOptions).forEach(([value, label]) => {
                if (value.startsWith(evt.detail.selectValue + '.')) {
                    choices.addOption({
                        value: value.replace(evt.detail.selectValue + '.', ''),
                        text: label
                    });
                }
            })
        }
    }

    disconnect() {
        if(this.choices) {
            this.choices.destroy();
        }
    }

    resetValue(value) {
        const self = this;
        const choices = self.choices;
        const element = self.element;
        const select = element.querySelector('select');

        let currentValues = value ?? choices.getValue();

        currentValues = JSON.parse(currentValues + '');

        if (!Array.isArray(currentValues)) {
            currentValues = [currentValues]
        }

        // 為了維持被選取的順序，必需清空後再重新填入
        if (currentValues.length) {
            choices.clear()
            currentValues.forEach(function (el) {
                if (choices.getItem(el)) {
                    choices.addItem(el);
                } else {
                    choices.createItem(el, function () {
                        choices.addItem(el);
                    });
                }
            });
            choices.trigger('change')
        }


    }

}
