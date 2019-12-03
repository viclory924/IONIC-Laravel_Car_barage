import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { HttpClient } from '@angular/common/http';
import { Global } from '../../components/global';
import { PaginationResponse } from '../../components/PaginationResponse';
import { DataResponse } from '../../components/DataResponse';
import { HomePage } from '../home/home';
import { Geolocation } from '@ionic-native/geolocation';
import { WorkshopDetailsPage } from '../workshop-details/workshop-details';

/**
 * Generated class for the WorkshopPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-workshop',
  templateUrl: 'workshop.html',
})
export class WorkshopPage {
  dataContent: any = [];
  viewData: any = [];
  nextPage = 1;
  maxPage = 1;
  viewRate = 'no'
  latitude: any = '';
  longitude: any = '';


  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public http: HttpClient,
    public global: Global,
    public geolocation: Geolocation) {

  }



  ionViewDidLoad() {
    this.load();
    this.viewRate = localStorage.getItem('rate');
  }

  load() {
    this.global.loadingSpinner();
    this.geolocation.getCurrentPosition().then((resp) => {
      this.latitude = resp.coords.latitude
      this.longitude = resp.coords.longitude
      let url = this.global.url + 'home?page=' + this.nextPage + '&lat=' + this.latitude + '&lng=' + this.longitude + '&APP_KEY=base64:D8USZ32W3i7JqP1zEymTiPBZP5ac9Lx/C43R5Yx11AU=';
      this.http.get(url, {
        headers: this.global.noheader
      })
        .toPromise()
        .then((result: PaginationResponse<any>) => {
          this.global.customLoading.dismiss();
          if (result.error == '200') {
            this.dataContent = result.data.data;
            this.maxPage = result.last_page;
            for (var i = 0; i < this.dataContent.length; i++) {
              this.viewData.push(this.dataContent[i]);
            }
            this.nextPage++;
          } else {
            this.global.alertMsg('error', 'server_400');
          }
        })
        .catch((error: DataResponse<any>) => {
          this.global.customLoading.dismiss();
          console.log(error)
          this.global.alertMsg('error', 'server_error');
        });
    }).catch((error) => {
      this.global.customLoading.dismiss();
      console.log(error);
      if (error.message) {
        this.global.alertMsg('error', error.message);
      }
      console.log('Error getting location', error);
    });

  }

  doInfinite(infiniteScroll: any) {
    if (this.nextPage <= this.maxPage) {
      return this.load();
    } else {
      infiniteScroll.complete();
    }
  }

  goBack() {
    this.navCtrl.setRoot(HomePage)
  }

  openWorkshopDetails(id: any) {
    console.log(id);
    this.navCtrl.setRoot(WorkshopDetailsPage, { id: id });
  }

}
