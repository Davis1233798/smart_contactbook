import './bootstrap';

import MatrixExController from "./controllers/matrix_ex_controller";
import SelectExController from "./controllers/select_ex_controller";

import RankSwapController from "./controllers/rank_swap_controller";
import FullscreenController from "./controllers/fullscreen_controller";
import AttributeController from "./controllers/attribute_controller";
import FileUploadController from "./controllers/file_upload_controller";
import FileUploadModalController from "./controllers/file_upload_modal_controller";
import TenantController from "./controllers/tenant_controller";  // 新加入的 Controller

application.register("matrix-ex", MatrixExController);
application.register("select-ex", SelectExController);

application.register("rank-swap", RankSwapController);
application.register("fullscreen", FullscreenController);
application.register("attribute", AttributeController);
application.register("file-upload", FileUploadController);
application.register("file-upload-modal", FileUploadModalController);
application.register("tenant", TenantController);  // 新加入的 Controller 註冊
