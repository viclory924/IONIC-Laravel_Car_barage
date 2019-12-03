import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { HomePage } from '../home/home';
import { Global } from '../../components/global';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { PaginationResponse } from '../../components/PaginationResponse';
import { DataResponse } from '../../components/DataResponse';

/**
 * Generated class for the NotiPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-noti',
  templateUrl: 'noti.html',
})
export class NotiPage {
  dataContent: any = [];
  viewData: any = [];
  nextPage = 1;
  maxPage = 1;

  constructor(public navCtrl: NavController, 
    public navParams: NavParams,
    public global: Global,
    public http: HttpClient) {
  }

  ionViewDidLoad() {
    localStorage.setItem('notiCount', '');
    localStorage.removeItem('notiCount');
    this.load();
  }

  load(){
    this.global.loadingSpinner();
    this.http.get(this.global.url+'openNotiPage/?page='+this.nextPage, { headers: new HttpHeaders({ Authorization: "Bearer " + localStorage.getItem("token") }) })
    .toPromise()
    .then((result: PaginationResponse<any>) => {
      console.log(result);
      this.global.customLoading.dismiss();
      if (result.error == 'success') {
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
  }

  goBack() {
    this.navCtrl.setRoot(HomePage)
  }

  doInfinite(infiniteScroll: any) {
    if (this.nextPage <= this.maxPage) {
      return this.load();
    } else {
      infiniteScroll.complete();
    }
  }

}
