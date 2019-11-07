import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

import { UserModel } from '../models/user-model';
import { CONSTANTS } from '../constants/constants';
import { IAPIResponse } from '../models/interfaces/api-response-interface';
import { API_RESPONSE } from '../constants/api-response';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  email: string;
  showName: boolean = false;
  name: string;
  userModel: UserModel = null;

  constructor (
    private http: HttpClient,
    private router: Router
  ) {
    this.userModel = new UserModel();
  }

  onSubmit() {
    if (!this.showName) {
      //Trying the submit
      this.userModel.email = this.email;
      this.http.post(CONSTANTS.SERVER_URL + 'user', this.userModel)
        .subscribe((response: IAPIResponse) => {
          if (response.statusCode == API_RESPONSE.OK) {
            this.userModel = response.data as UserModel;
            this.userModel.new_user = Number(response.data.new_user);
            if (this.userModel.new_user) {
              this.showName = true;
            } else {
              this.router.navigate(['game']);
            }
          }
        });
    } else {
      //Updating the name
      this.userModel.email = this.email;
      this.userModel.name = this.name;
      this.http.put(CONSTANTS.SERVER_URL + 'user/' + this.userModel.id, this.userModel)
        .subscribe((response: IAPIResponse) => {
          if (response.statusCode == API_RESPONSE.OK) {
            this.userModel = response.data as UserModel;
            this.router.navigate(['game']);
          }
        });
    }
  }
}
