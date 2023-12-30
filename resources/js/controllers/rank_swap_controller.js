export default class extends window.Controller {

    static targets = [
        'rank'
    ];

    updaing = false

    connect() {
        this.getRankData()
    }

    getRankData() {
        const fieldName = this.data.get('field-name');
        const rankSwap = this.element
            .parentElement.closest('table > tbody > tr')
            .parentNode.querySelectorAll('div.rank-swap')

        let rankData = []
        rankSwap.forEach(function (el, index) {
            el.querySelector('.rank-no').innerHTML = index + 1

            let field = 'rank_swap';
            if (fieldName && fieldName.length) {
                field = fieldName;
            }
            el.querySelector('.col-rank-no').value = index
            el.querySelector('.col-rank-no').name = field + '[' + index + '][rankNo]';
            el.querySelector('.col-model-id').value = el.dataset.rankSwapModelId
            el.querySelector('.col-model-id').name = field + '[' + index + '][modelId]';

            rankData.push({
                modelId: el.dataset.rankSwapModelId,
                rankNo: index
            })
        })

        if (fieldName && fieldName.length) {
            let data = {};
            data[fieldName] = rankData;
            return data;
        }
        return rankData;
    }

    ajaxUpdateRank(data) {
        const self = this;
        const formMethod = this.data.get('form-method');
        const formAction = this.data.get('form-action');
        const autoSubmit = this.data.get('auto-submit');

        if (!formAction) {
            return;
        }

        if (autoSubmit) {
            self.updaing = true;
            axios({
                method: formMethod,
                url: formAction,
                data: this.getRankData()
            }).then(function () {
                self.updaing = false;
            });
        }
    }

    swapUp(event) {
        event.preventDefault();

        if (this.updaing) {
            return false;
        }

        const link = event.target.parentNode.parentNode;
        const row = link.parentElement.closest('tbody > tr');
        const sibling = row.previousElementSibling;
        const parent = row.parentNode;

        if (sibling && sibling.querySelector('div.rank-swap')) {
            const prevMeta = sibling.querySelector('div.rank-swap');
            if (prevMeta) {
                parent.insertBefore(row, sibling);
                this.ajaxUpdateRank();
            }
        }
        return false;
    }

    swapDown(event) {
        event.preventDefault();

        if (this.updaing) {
            return false;
        }

        const link = event.target.parentNode.parentNode;
        const row = link.parentElement.closest('tbody > tr');
        const sibling = row.nextElementSibling;

        if (sibling) {
            const nextMeta = sibling.querySelector('div.rank-swap');
            if (nextMeta) {
                sibling.parentNode.insertBefore(row, sibling.nextSibling);
                this.ajaxUpdateRank();
            }
        }

        return false;
    }
}
