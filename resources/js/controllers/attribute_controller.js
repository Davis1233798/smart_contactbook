export default class extends Controller {

  static targets = [
    'index'
  ];

  // 初始化
  connect() {
    // console.log("Me, ", this.element);
    
    // 帶入資料庫資料
    this.ajaxInitialAttribute();
  }

  // 新增 1 組
  addRow(attributeKeys = [], attributeValues = []) {
  
    // 取得作用表格
    let table = document.querySelector(".attribute-list");
    
    // 新增欄位描述
    let totalrows = document.querySelectorAll(".attribute-list tr").length;
    let row = table.insertRow(totalrows);

    for (let i = 0; i < 6; i++) {
      let cellTitle = "cellTitle" + i;

      cellTitle = row.insertCell(i);

      if (i == 5 ) {
        cellTitle.innerHTML = "<button type='button' class='form-control btnDelete btn btn-danger pt-2 pb-2' data-action='attribute#deleteRow' size='1' height='1'>刪除</button>";
      } else {
        if ( typeof(attributeKeys[i]) !== "undefined" && attributeKeys[i] !== null ) {
          // console.log(attributeKeys[i]);
          cellTitle.innerHTML = "<input class='form-control color' type='text' name='attributeKey[]' value='" + attributeKeys[i] +"'>";
        
        } else {
          cellTitle.innerHTML = "<input class='form-control color' type='text' name='attributeKey[]' placeholder='欄位描述'>";
        } 
      }
      
    }

    // 新增欄位值
    let totalrows1 = document.querySelectorAll(".attribute-list tr").length;
    let row1 = table.insertRow(totalrows1);

    for (let i = 0; i < 6; i++) {
      let cellInput = "cellInput" + i;

      cellInput = row1.insertCell(i);

      if (i == 5 ) {
        cellInput.innerHTML = "";
      } else {
        if ( typeof(attributeValues[i]) !== "undefined" && attributeValues[i] !== null ) {
          // console.log(attributeValues[i]);
          cellInput.innerHTML = "<input class='form-control' type='text' name='attributeValue[]' value='" + attributeValues[i] +"'>";
      
        } else {
          cellInput.innerHTML = "<input class='form-control' type='text' name='attributeValue[]' placeholder='欄位值'>";
        } 
      }
      
    }

  }

  // 刪除 1 組
  deleteRow(event){

    let path = event.path || (event.composedPath && event.composedPath());
    path.forEach((target) => {
      if (target.tagName !== 'TR') {
          return;
      }
      
      // 取得這一列 rowIndex
      let thisIndex = target.rowIndex;

      // 取得下一列 rowIndex
      let nextIndex = thisIndex+1;

      // 取得作用表格
      let table = document.querySelector('.attribute-list');

      // 刪除下一列
      table.deleteRow(nextIndex);

      // 刪除這一列
      target.parentNode.removeChild(target);
    });
    
  }

  // 匯入範本
  callTemplate1() {
    this.ajaxCallTemplate(1);
  }
  
  callTemplate2() {
    this.ajaxCallTemplate(2);
  }

  callTemplate3() {
    this.ajaxCallTemplate(3);
  }
  
  ajaxCallTemplate(code, data) {
    const self = this;
    const formMethod = this.data.get('form-method');
    let formAction = this.data.get('form-action');

    if (!formAction) {
        return;
    }

    formAction = formAction + '/callTemplate';
    // console.log(formAction);

    // AJAX 回傳
    axios({
      method: formMethod,
      url: formAction,
      data: {
        code: code
      }
      
    }).then(response =>{
      const text = response.data.name;
      const myArray = text.split(",");
      const myLength = myArray.length;

      // console.dir(myArray);
      // console.log(myArray[0]);

      if (myArray[0] === "") {
        alert('匯入失敗！範本為空');

      } else {
        // 重繪作用表格
        document.querySelector(".attribute-list").innerHTML = "";
        
        // 實際要新增的組數 (1組 5 個)
        const groups = Math.ceil(myLength/5);

        for (let i = 0; i < groups; i++) {
          // 塞值
          let fillKeys = [];
          let start = i*5;
          let end = start + 5;
          
          // console.log(start);

          for (let j = start; j < end; j++) {
            if (myArray[j]) {
              fillKeys.push(myArray[j]);
            }
            // console.log(i + '  ' + j);
          }

          // console.dir(fillKeys);
          this.addRow(fillKeys);
        }
      }

    }).catch(err =>{
      console.log(err);
    });
  }

  // 儲存範本
  saveTemplate1() {
    this.ajaxSaveTemplate(1);
  }
  
  saveTemplate2() {
    this.ajaxSaveTemplate(2);
  }

  saveTemplate3() {
    this.ajaxSaveTemplate(3);
  }

  ajaxSaveTemplate(code, data) {
    const self = this;
    const formMethod = this.data.get('form-method');
    let formAction = this.data.get('form-action');

    if (!formAction) {
        return;
    }

    formAction = formAction + '/saveTemplate';
    // console.log(formAction);

    // 組裝範本標題
    let input = document.getElementsByName('attributeKey[]');
    let name = "";
    for (let i = 0; i < input.length; i++) {
      let saveKey = input[i].value;

      if (saveKey.length > 0) {
        name = name + saveKey + ",";
      }
    }
    name = name.slice(0,-1);

    // AJAX 寫入
    try {
      axios({
        method: formMethod,
        url: formAction,
        data: {
          code: code,
          name: name
        }
      });
      return alert("存檔成功！");
    } catch (error) {
      return alert("Error: " + error);
    }
  }

  ajaxInitialAttribute() {
    const formMethod = this.data.get('form-method');
    let formAction = this.data.get('form-action');

    if (!formAction) {
        return;
    }

    formAction = formAction + '/showeAttributes';
    // console.log(formAction);

    // AJAX 回傳
    axios({
      method: formMethod,
      url: formAction
      
    }).then(response =>{
      const obj = response.data;
      const keys = Object.keys(obj);
      const keysLength = keys.length;
      // console.dir(keys);

      const values = Object.values(obj);
      const valuesLength = values.length;
      // console.dir(values);

      // 重繪作用表格
      document.querySelector(".attribute-list").innerHTML = "";
      
      // 實際要新增的組數 (1組 5 個)
      const groups = Math.ceil(keysLength/5);

      for (let i = 0; i < groups; i++) {
        // 塞值
        let fillKeys = [];
        let fillValues = [];
        let start = i*5;
        let end = start + 5;
        
        // console.log(start);

        for (let j = start; j < end; j++) {
          if (keys[j]) {
            fillKeys.push(keys[j]);
            fillValues.push(values[j]);
          }
          // console.log(i + '  ' + j);
        }

        // console.dir(fillKeys);
        this.addRow(fillKeys, fillValues);
      }

    }).catch(err =>{
      console.log(err);
    });
  }
}