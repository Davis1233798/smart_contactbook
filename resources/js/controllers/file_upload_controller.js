export default class extends window.Controller {

    static targets = [
        'index', 
        'modal'
    ];

    // --- 開始：程式從 matrix_ex_controller.js 拷貝
    connect() {
        this.template = this.element.querySelector('.matrix-template');
        this.keyValueMode = this.data.get('key-value') === 'true';

        let initRows = parseInt(this.data.get('init-rows'), 10);
        const maxRows = parseInt(this.data.get('rows'), 10);

        // 如果有指定最大列數，進行修正
        if(maxRows) {
            initRows = (initRows > maxRows) ? maxRows : initRows;
        }

        // 預設密等值
        document.getElementById("field-radio-a").checked = true;

        // for (let i = 0; i < initRows; i++) {
        //     this.addRow(new Event('click'));
        // }
        // this.detectMaxRows();
    }

    deleteRow(event) {
        let path = event.path || (event.composedPath && event.composedPath());

        path.forEach((element) => {
            if (element.tagName !== 'TR') {
                return;
            }

            element.parentNode.removeChild(element);
        });

        // this.detectMaxRows();
        event.preventDefault();
        return false;
    }

    /**
     *
     * @returns {number}
     */
    get index() {
        return parseInt(this.data.get('index'));
    }

    /**
     *
     * @param value
     */
    set index(value) {
        this.data.set('index', value);
    }

    /**
     * Shows or hides the addition
     * of a new line based on line counting
     */
    // detectMaxRows() {
    //     const max = parseInt(this.data.get('rows'));
    //     if (max === 0) {
    //         return;
    //     }

    //     let current = this.element.querySelectorAll('tbody tr:not(.add-file)').length;
    //     let addRow = this.element.querySelector('.add-file th');
    //     addRow.style.display = max <= current ? 'none' : '';
    // }

    dragUpRow(event) {
        event.preventDefault();

        const row = event.target.parentNode.parentNode;
        const sibling = row.previousElementSibling;
        const parent = row.parentNode;

        if (sibling && sibling.classList.contains("draggable")) {
            parent.insertBefore(row, sibling);
        }

        return false;
    }

    dragDownRow(event) {
        event.preventDefault();

        const row = event.target.parentNode.parentNode;
        const sibling = row.nextElementSibling;

        if (sibling && sibling.classList.contains("draggable")) {
            sibling.parentNode.insertBefore(row, sibling.nextSibling);
        }
        return false;
    }
    // --- 結束：程式從 matrix_ex_controller.js 拷貝

    // 上傳檔案
    addFile(event) {
        const modalController = this.application.getControllerForElementAndIdentifier(
            this.modalTarget,
            "file-upload-modal"
        );
        // console.log(modalController);
        modalController.setCoHostContent(event.currentTarget.dataset);    
        modalController.open();

        // this.detectMaxRows();
        event.preventDefault();
        return false;
    }

}