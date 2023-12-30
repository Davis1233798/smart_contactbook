// resources/js/controllers/tenant_controller.js



export default class extends Controller {
    static targets = ["select", "hiddenInput"];

    connect() {
        console.log("Tenant controller connected!");
        this.updateHiddenInput();  // Update hidden input on load
    }

    updateHiddenInput() {
        this.hiddenInputTarget.value = this.selectTarget.value;
    }

    openTenantWindow() {
        const tenantId = this.selectTarget.value;
        const url = `${window.App.url}/orchid/tenants/tenant/show/${tenantId}`;
        window.open(url, "_blank");
    }
}
