<script>
import { mapGetters } from "vuex";
import Card from "./../components/EapComponents/Widgets/Cards/Card";
import BoxCard from "./../components/EapComponents/Widgets/Cards/BoxCard";
import BaseButton from "./../components/EapComponents/UIElements/Buttons/BaseButton";
import ImageIcon from "./../components/EapComponents/UIElements/ImageIcon";
import BaseInput from "./../components/EapComponents/Inputs/BaseInput";
import DropzoneFileUpload from "./../components/EapComponents/Inputs/DropzoneFileUpload";
import Select from "./../components/EapComponents/Inputs/Select";
import MultiSelect from "./../components/EapComponents/Inputs/MultiSelect";
import DataTable from "./../components/EapComponents/Datatable/Datatable";
import Pagination from "./../components/EapComponents/Datatable/Pagination";
import NavbarButton from "./../components/EapComponents/UIElements/Buttons/NavbarButton";
import FileInput from "./../components/EapComponents/Inputs/FileInput";
import Modal from "./../components/EapComponents/UIElements/Modal";
import AsyncSelect from "./../components/EapComponents/Inputs/AsyncSelect";
import EapButton from "./../components/EapComponents/UIElements/Buttons/EapButton";
import LineChart from "./../components/EapComponents/Widgets/charts/LineChart.js";
import PieChart from "./../components/EapComponents/Widgets/charts/PieChart.js";

export default {
  components: {
    Card,
    BaseButton,
    BaseInput,
    DropzoneFileUpload,
    Select,
    MultiSelect,
    ImageIcon,
    DataTable,
    Pagination,
    NavbarButton,
    FileInput,
    BoxCard,
    Modal,
    AsyncSelect,
    EapButton,
    LineChart,
    PieChart
  },
  data() {
    return {
      isLoading: false,
      returnAccess: false,
      isTableBoxView: false,
      editorConfig: {
        toolbar: {
          items: ["bold", "italic", "link", "undo", "redo"]
        }
      }
    };
  },
  methods: {
    $playVideo(file, mime, disk) {},
    $can(permissionName) {
      let route = window.routes.permission;
      let returnAccess;
      axios
        .get(route + `/${permissionName}`)
        .then(resounse => {
          if (resounse.data == 101) {
            this.returnAccess = true;
          }
        })
        .catch(error => {
          this.returnAccess = false;
        });
      return this.returnAccess;
    },
    $filePreview(filetype, filename, fileDisk, base = null) {
      var $data;
      if (!base) {
        base = "file";
      }
      $("#filepreview-common").modal("show");
      $data = $(".file-Preview-format");
      if (
        filetype == "png" ||
        filetype == "jpg" ||
        filetype == "jpeg" ||
        filetype == "gif"
      ) {
        $data.html(
          '<a href="/' +
            base +
            "?name=" +
            filename +
            "&disk=" +
            fileDisk +
            '" class="button">Download</a><img src="/' +
            base +
            "?name=" +
            filename +
            "&disk=" +
            fileDisk +
            '" class="img-fluid attach-img" id="attachment-image" alt="">'
        );
        $("#rotateLeft").show();
        $("#rotateRight").show();
      } else if (filetype == "doc" || filetype == "docx") {
        $data.html(
          '<iframe src="https://docs.google.com/gview?url=/' +
            base +
            "?name=" +
            filename +
            "&disk=" +
            fileDisk +
            '&embedded=true" width="100%" height="600"></iframe>'
        );
        $("#rotateLeft").hide();
        $("#rotateRight").hide();
      } else if (filetype == "pdf") {
        $data.html(
          '<iframe src="/' +
            base +
            "?name=" +
            filename +
            "&disk=" +
            fileDisk +
            '" width="100%" height="600"></iframe>'
        );
        $("#rotateLeft").hide();
        $("#rotateRight").hide();
      } else if (filetype == "xls" || filetype == "xlsx") {
        $data.html(
          '<iframe src="/' +
            base +
            "?name=" +
            filename +
            "&disk=" +
            fileDisk +
            '" width="100%" height="600"></iframe>'
        );
        $("#rotateLeft").hide();
        $("#rotateRight").hide();
      } else {
        $data.html("Something went wrong");
        $("#rotateLeft").hide();
        $("#rotateRight").hide();
      }
    },
    $getAttachmentTemp(filetype) {
      var iconPath = "";
      if (filetype == "jpg" || filetype == "jpeg") {
        iconPath = "img/jpg.png";
      } else if (filetype == "doc" || filetype == "docx") {
        iconPath = "img/doc.png";
      } else if (filetype == "xls" || filetype == "xlsx") {
        iconPath = "img/xls.png";
      } else if (filetype == "png") {
        iconPath = "img/png.png";
      } else if (filetype == "pdf") {
        iconPath = "img/pdf.png";
      } else if (filetype == "gif") {
        iconPath = "img/gif.png";
      } else if (filetype == "listIcon") {
        iconPath = "img/attachment_icon.png";
      } else {
        iconPath = "img/file.png";
      }
      return `${base_url}/` + iconPath;
    },
    $videoPreview(filetype, filename, fileDisk, base = null) {
      if (!base) {
        base = "video";
      }
      var $data;
      $("#videoplayer-common").modal("show");
      $data = $(".video-Preview");
      // for youtube link iframe
      if (filetype == "url") {
        $data.html(
          '<vue-plyr><div class="plyr__video-embed"><iframe src=' +
            filename +
            ' allowfullscreen allowtransparency allow="autoplay"></iframe></div></vue-plyr>'
        );
      } else {
        $data.html(
          '<video controls>\n\
                <source src="/eventcourse/' +
            base +
            "?name=" +
            filename +
            '">\n\
                Your browser does not support the video tag.\n\
        </video>'
        );
      }
    },
    $backButton() {
      this.$router.go(-1);
    },
    $frwdButton() {
      this.$router.go(1);
    },
    $refreshButton() {
      this.$router.go(0);
    },
    $todoCount() {
      let route = window.routes.getuserCount;
      let todoCount;
      axios
        .get(route)
        .then(resounse => {
          if (resounse.data.status == 100) {
            this.todoCount = resounse.data.data;
          }
        })
        .catch(error => {
          this.todoCount = 0;
        });
      return null;
    },
    $mouse_disable() {
      document.getElementsByTagName("body")[0].style = "pointer-events: none";
    },
    $mouse_enable() {
      document.getElementsByTagName("body")[0].style = "pointer-events: auto";
    },
    $switchShowSidePage() {
      this.$store.commit("SHOW_SIDE_PAGE", this.showSidePage ? false : true);
    },
    $currencyCalculate(incomingCurrency, value) {
      let currentCurrency = this.currentCurrency;
      let currencyValues = this.currencyValues;
      if (currentCurrency == incomingCurrency) {
        return value;
      } else {
        let findCurrency = currencyValues.find(
          ({ currency }) => currency === incomingCurrency
        );
        if (findCurrency) {
          let usdBase = 1 / findCurrency.currency_value; //.toFixed(3)

          // let usdVal = Math((usdBase*value + Number.EPSILON) * 1000) / 1000;
          let usdVal = usdBase * value; //.toFixed(3);
          let findCurrentCurrency = currencyValues.find(
            ({ currency }) => currency === currentCurrency
          );
          // return usdVal*findCurrentCurrency.currency_value;
          let rVal = Math.ceil(usdVal * findCurrentCurrency.currency_value);
          if (rVal) {
            return rVal;
          }
        }
      }
      return "";
    },
    $toastSuccess(message = null) {
      toast.fire({
        title: message ? message : "Success",
        type: "success"
      });
    },
    $toastWarning(message = null) {
      toast.fire({
        title: message ? message : "Warning",
        type: "warning"
      });
    },
    $getGrapStyleTag(css) {
      return "<style scoped>" + css + "</style>";
    },
    $addParamsToLocation(params = false) {
      if (!params) {
        params = {
          search: this.tableData.search,
          page: this.pagination.currentPage
        };
      }
      history.pushState(
        {},
        null,
        this.$route.path +
          "?" +
          Object.keys(params)
            .map(key => {
              return (
                encodeURIComponent(key) + "=" + encodeURIComponent(params[key])
              );
            })
            .join("&")
      );
    },
    $locationsToTableData() {
      if (this.$route.query.search) {
        this.tableData.search = this.$route.query.search;
      }
      if (this.$route.query.page) {
        this.pagination.currentPage = this.$route.query.page;
      }
    }
  },
  computed: {
    ...mapGetters([
      "currentCurrency",
      "currencyValues",
      "showSidePage",
      "permissions",
      "countryOpt",
      "countryAll"
    ])
  },
  mounted() {}
};
</script>
