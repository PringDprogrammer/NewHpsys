<template>
	<div class="container-fluid">
  	<div class="card">
  		<div class="card-header">
        <h3>Choose Report:</h3>		
  		</div>
  		<div class="card-body">
        <div class="form-group">
          <label>Hospital : </label>
          <select class="browser-default custom-select" v-model="select_hospital">
            <option value="">Select hospital...</option>
            <option v-for="selecthospital in selecthospitals">
              {{selecthospital}}
            </option>
          </select>
        </div>
  			<div class="form-group">
          <label>Title : </label>
          <select class="browser-default custom-select" v-model="select_patient">
            <option value="">Select title...</option>
            <option v-for="selectpatient in selectpatiens">
              {{selectpatient}}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Report Type : </label>
          <select class="browser-default custom-select" v-model="select_reportType">
            <option value="">Select report type...</option>
            <option v-for="reportType in reportTypes">
              {{reportType}}
            </option>
          </select>
        </div>
        <div v-if="select_reportType == 'Daily' " class="form-group">
          <div class="daily">
            <label>Date : </label>
              <datepicker :bootstrap-styling="true"
                          v-model="dailyDate"
                          id="datepic"
                          :format="customFormatter"
                          placeholder="MM-DD-YYYY"
                          required>
              </datepicker>
          </div>
        </div>
        <div class="Monthly" v-else-if="select_reportType == 'Monthly' ">
          <div class="row">
            <div class="col">
              <label>From:</label>
              <datepicker :bootstrap-styling="true"
                            v-model="dateFrom" 
                            :format="FromcustomFormatter"
                            placeholder="MM-DD-YYYY"
                            required>
              </datepicker>
            </div>
            <div class="col">
              <label>To:</label>
              <datepicker :bootstrap-styling="true"
                            v-model="dateTo" 
                            :format="TocustomFormatter"
                            placeholder="MM-DD-YYYY"
                            required>
              </datepicker>
            </div>
          </div>
          <div>&nbsp;</div>
          <div class="form-group" align="center">
            <button class="btn btn-primary" @click="monthlyReport">Ok</button>
          </div>
        </div>
        
        <template>
          <div class="content form-group" v-if="select_patient == 'Walkin' " id="content" >
            <div align="center">
              <span>{{ select_hospital }}</span>
            </div>
            <div align="center">
              <span>{{ select_patient }} {{ select_reportType }} Report</span>
            </div>
            <div align="center">
              <span v-if="select_reportType == 'Daily' ">
                {{ dailyDate }}
              </span>
              <span v-else>
                {{ dateFrom }} - {{ dateTo }}
              </span>
            </div>
          </div>
          <template>

          <div v-if="select_patient == 'Walkin'" style="overflow-x:auto;">
            <table class="table " width="100%" id="content-table">
              <thead>
                <th width="500px">Date</th><!--transaction date-->
                <th>Name</th><!--inPatient Name-->
                <th>Order Slip</th><!--Customize ID-->
                <th>Consignor</th>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>Qty</th><!--quantity-->
                <th>Sell Price</th><!--item selling price-->
                <th>Total Sales</th><!--qty + sellPrice-->
                <th>Discount Type</th>
                <th>Discount</th>
                <th>Net Total</th><!--overAll total-->
                <th>Cash</th>
                <th>CashRef</th>
                <th>Coupon</th>
                <th>CoupoRef</th>
                <th>Phic</th>
                <th>PhicRef</th>
                <th>Others</th>
                <th>OthersAmount</th>
                <th>OthersRef</th>
              </thead>
              <tbody>
                <template v-if="!walkinreportsdata.length">
                  <tr>
                      <td colspan="20" class="text-center">No records found in the database</td>
                  </tr>
                </template>
                <tr v-for="walkinreport in walkinreportsdata">
                  <td>{{walkinreport.transdate}}</td>
                  <td>{{walkinreport.fullname}}</td>
                  <td>{{walkinreport.walkin_id}}</td>
                  <td>{{walkinreport.consignor}}</td>
                  <td>{{walkinreport.itemcode}}</td>
                  <td>{{walkinreport.itemName}}({{walkinreport.itemType}})</td>
                  <td>{{walkinreport.quantity}}</td>
                  <td>{{formatPrice(walkinreport.sellPrice)}}</td>
                  <td>{{formatPrice(walkinreport.itemTotal)}}</td>
                  <td>{{walkinreport.discountType}}</td>
                  <td>{{formatPrice(walkinreport.discount)}}</td>
                  <td>{{formatPrice(walkinreport.sumtotal)}}</td>
                  <td>{{formatPrice(walkinreport.cash)}}</td>
                  <td>{{walkinreport.cashref}}</td>
                  <td>{{formatPrice(walkinreport.coupon)}}</td>
                  <td>{{walkinreport.couponref}}</td>
                  <td>{{formatPrice(walkinreport.phic)}}</td>
                  <td>{{walkinreport.phicref}}</td>
                  <td>{{walkinreport.others}}</td>
                  <td>{{formatPrice(walkinreport.othersamount)}}</td>
                  <td>{{walkinreport.othersref}}</td>
                </tr>
              </tbody>
            </table>
          </div>      
          </template>
          <div class="form-group" v-if="select_patient == 'In-Patient' " id="content">
            <div align="center">
              <span>{{ select_hospital }}</span>
            </div>
            <div align="center">
              <span>{{ select_patient }} {{ select_reportType }} Report</span>
            </div>
            <div align="center">
              <span v-if="select_reportType == 'Daily' " >
                {{ dailyDate }}
              </span>
              <span v-else>
                {{ dateFrom }} - {{ dateTo }}
              </span>
            </div>
          </div>
          <template>
            <div v-if="select_patient == 'In-Patient'" style="overflow-x:auto;">
              <table class="table" width="100%" id="content-table">
                <thead>
                  <th>Date</th><!--transaction date-->
                  <th>Name</th><!--inPatient Name-->
                  <th>Order Slip</th><!--Customize ID-->
                  <th>Consignor</th>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Qty</th><!--quantity-->
                  <th>Sell Price</th><!--item selling price-->
                  <th>Total Sales</th><!--qty + sellPrice-->
                  <th>Discount Type</th>
                  <th>Discount</th>
                  <th>Net Total</th><!--overAll total-->
                  <th>Cash</th>
                  <th>CashRef</th>
                  <th>Coupon</th>
                  <th>CoupoRef</th>
                  <th>Phic</th>
                  <th>PhicRef</th>
                  <th>Others</th>
                  <th>OthersRef</th>
                </thead>
                <tbody>
                  <template v-if="!inpatientreports.length">
                    <tr>
                        <td colspan="20" class="text-center">No records found in the database</td>
                    </tr>
                  </template>
                  <tr v-for="reportdata in inpatientreports">
                    <td>{{reportdata.transdate}}</td>
                    <td>{{reportdata.fullname}}</td>
                    <td>{{reportdata.inpatient_id}}</td>
                    <td>{{reportdata.consignor}}</td>
                    <td>{{reportdata.itemcode}}</td>
                    <td>{{reportdata.itemName}}({{reportdata.itemType}})</td>
                    <td>{{reportdata.quantity}}</td>
                    <td>{{formatPrice(reportdata.sellPrice)}}</td>
                    <td>{{formatPrice(reportdata.itemTotal)}}</td>
                    <td>{{reportdata.discountType}}</td>
                    <td>{{formatPrice(reportdata.discount)}}</td>
                    <td>{{formatPrice(reportdata.sumtotal)}}</td>
                    <td>{{formatPrice(reportdata.cash)}}</td>
                    <td>{{reportdata.cashref}}</td>
                    <td>{{formatPrice(reportdata.coupon)}}</td>
                    <td>{{reportdata.couponref}}</td>
                    <td>{{formatPrice(reportdata.phic)}}</td>
                    <td>{{reportdata.phicref}}</td>
                    <td>{{formatPrice(reportdata.others)}}</td>
                    <td>{{reportdata.othersref}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </template>
        </template>
  		</div>
      <div class="card-footer">
        <div class="form-group" v-if="select_patient == 'Walkin'">
          <div class="form-group" v-if="select_reportType == 'Daily'">
            <export-excel class="btn" 
                          :data = "wreport" 
                          :fields = "json_fields"
                          type = "csv"
                          :name = "setDailyFileName()">Download Excel
            </export-excel>
          </div>
          <div class="form-group" v-else-if="select_reportType == 'Monthly' ">
            <export-excel class="btn btn-default" 
                          :data = "wreport" 
                          :fields = "json_fields"
                          type = "csv"
                          :name = "setMonthlyFileName()">Download Excel
            </export-excel>
          </div>
        </div>
        <div class="form-group" v-if="select_patient == 'In-Patient'">
          <div class="form-group" v-if="select_reportType == 'Daily'">
            <export-excel class="btn" 
                          :data = "patientreports" 
                          :fields = "json_fields_patient"
                          type = "csv"
                          :name = "setDailyFileName()">Download Excel
            </export-excel>
          </div>
          <div class="form-group" v-else-if="select_reportType == 'Monthly' ">
            <export-excel class="btn btn-default" 
                          :data = "patientreports" 
                          :fields = "json_fields_patient"
                          type = "csv"
                          :name = "setMonthlyFileName()">Download Excel
            </export-excel>
          </div>
        </div>
        <div class="row">
          <div class="col" right>
            <button class="btn" @click="refresh">Cancel</button>
          </div>
        </div>
      </div>
  	</div>
  </div>

</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    import excel from 'vue-excel-export';
    import DatePicker from 'vue2-datepicker';
    export default {
        name: 'report-list',
        components: {
            Datepicker,
            DatePicker
        },
        data() {
          return {
            select_hospital: '',
            select_reportType: '',
            select_patient: '',
            dailyDate: '',
            dateFrom: '',
            dateTo: '',
            patientreports: [],
            wreport: [],
            selecthospitals: [
              'Candelaria Hospital'
            ],
            selectpatiens: [
              'Walkin',
              'In-Patient'
            ],
            reportTypes: [
              'Daily',
              'Monthly'
            ],
            json_fields: {
              'Date': 'transdate',
              'Name': 'fullname',
              'Order Slip': 'walkin_id',
              'Consignor': 'consignor',
              'Item Code': 'itemcode',
              'Item Description': 'itemName',
              'Qty': 'quantity',
              'Sell Price': 'sellPrice',
              'Total Sales': 'itemTotal',
              'Discount Type': 'discountType',
              'Discount': 'discount',
              'Net Total': 'sumtotal',
              'cash': 'cash',
              'cashref': 'cashref',
              'coupon': 'coupon',
              'couponref': 'couponref',
              'phic': 'phic',
              'phicref': 'phicref',
              'others': 'others',
              'OthersAmount': 'othersamount',
              'othersref': 'othersref'
            },
            json_fields_patient: {
              'Date': 'transdate',
              'Name': 'fullname',
              'Order Slip': 'inpatient_id',
              'Consignor': 'consignor',
              'Item Code': 'itemcode',
              'Item Description': 'itemName',
              'Qty': 'quantity',
              'Sell Price': 'sellPrice',
              'Total Sales': 'itemTotal',
              'Discount Type': 'discountType',
              'Discount': 'discount',
              'Net Total': 'sumtotal',
              'cash': 'cash',
              'cashref': 'cashref',
              'coupon': 'coupon',
              'couponref': 'couponref',
              'phic': 'phic',
              'phicref': 'phicref',
              'others': 'others',
              'OthersAmount': 'othersamount',
              'othersref': 'othersref'
            },
            month: '',
          };
        },
        watch: {
          dailyDate: function() {
            var dailyfilterDate = moment(this.$data.dailyDate).format();
            const dateForm = {
              select_patient: this.$data.select_patient,
              dailyDate: dailyfilterDate
            }
            axios.get('/api/report', {params: dateForm })
                .then((response) => {
                  this.wreport = response.data.walkinreports;
                  this.patientreports = response.data.inpatientsReport;
                });
            
          }
        },
        computed: {
          walkinreportsdata() {
            return this.wreport;
          },
          inpatientreports() {
            return this.patientreports;
          },

        },
        methods: {
          monthlyReport() {
            var fromDatefilter = moment(this.$data.dateFrom).format();
            var toDatefilter = moment(this.$data.dateTo).format();
            const dateForm = {
              select_patient: this.$data.select_patient,
              fromDate: fromDatefilter,
              toDate: toDatefilter 
            }
            axios.get('/api/report/getMonthlyDate', {params: dateForm })
                .then((response) => {
                  this.wreport = response.data.walkinreports;
                  this.patientreports = response.data.inpatientsReport;
                });
          },
          //format number to 2 decimal places
          formatPrice(value) {
              let val = (value/1).toFixed(2).replace('.', ',')
              return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          //Date format
          customFormatter(dailyDate) {
              return this.dailyDate = moment(dailyDate).format('MM-DD-YYYY');
          },
          FromcustomFormatter(dateFrom) {
              return this.dateFrom = moment(dateFrom).format('MM-DD-YYYY');
          },
          TocustomFormatter(dateTo) {
              return this.dateTo = moment(dateTo).format('MM-DD-YYYY');
          },
          refresh() {
            return location.reload('/report');
          },
          setDailyFileName(dailyDate) {
            var date = this.dailyDate;
            return `DailyReport${date}.xls`;
          },
          setMonthlyFileName(dateFrom, dateTo){
            var date1 = this.dateFrom;
            var date2 = this.dateTo;
            return `MonthlyReport${date1}&${date2}.xls`;
          }
        }
    };
</script>

<style scoped>
.btn-wrapper {
    text-align: right;
    margin-bottom: 20px;
}
</style>