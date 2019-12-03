import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { TranslateService } from '@ngx-translate/core';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { DataResponse } from '../../components/DataResponse';



/**
 * Generated class for the HeaderPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-header',
  templateUrl: 'header.html',
})
export class HeaderPage {
  pageTitle: string = '';

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public translate: TranslateService,
    public global: Global,
    public http: HttpClient) {

    let key = localStorage.getItem('pageTitle');
    this.pageTitle = this.translate.instant(key);
    this.notification();
    this.setLang();
    this.getDeviceLocation();
    this.getSetting();
  }

  setLang() {

    if (localStorage.getItem('lang') != null) {
      this.global.lang = localStorage.getItem('lang');
      this.global.align = localStorage.getItem('align');
      this.global.dirction = localStorage.getItem('dirction');
      this.global.otherAlign = localStorage.getItem('otherAlign');
      this.global.otherDirction = localStorage.getItem('otherDirction');
    } else {
      localStorage.setItem('lang', this.global.lang);
      localStorage.setItem('align', this.global.align);
      localStorage.setItem('dirction', this.global.dirction);
      localStorage.setItem('otherAlign', this.global.otherAlign);
      localStorage.setItem('otherDirction', this.global.otherDirction);
    }
  }

  getSetting() {
    this.http.get(this.global.url + 'setting', {
      headers: this.global.noheader
    }).toPromise()
      .then((result: DataResponse<any>) => {
        if (result.error == '200') {
          localStorage.setItem('fees', result.data[0].value);
          localStorage.setItem('rate', result.data[1].value);
          localStorage.setItem('customer', result.data[2].value);
          localStorage.setItem('workshop', result.data[3].value);
        } else {
          this.global.alertMsg('error', 'server_400');
        }
      })
      .catch((error: DataResponse<any>) => {
        console.log(error);
        this.global.alertMsg('error', 'server_error');
      })
  }

  notification() {
    console.log('check have notification')
  }

  getDeviceLocation() {
    // this.geolocation.getCurrentPosition().then((resp) => {
    //   // resp.coords.latitude
    //   // resp.coords.longitude
    //   console.log(resp);
    //  }).catch((error) => {
    //    console.log('Error getting location', error);
    //  });

    //  let watch = this.geolocation.watchPosition();
    //  watch.subscribe((data) => {
    //   // data can be a set of coordinates, or an error (if an error occurred).
    //   // data.coords.latitude
    //   // data.coords.longitude
    //   console.log(data);
    //  });
  }

  

}
