import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {ToastrService} from 'ngx-toastr';
import { sleep } from '@/utils/helpers';
import { HttpClient } from '@angular/common/http';
interface AuthObject {
  status: boolean;
  user: User;
  message: string;
  access_token: string;
  token_type: string;
  expires_at: string;
}

interface User {
  id: number;
  nombre: string;
  apellido: string;
  email: string;
  deleted_at: null;
  created_at: string;
  updated_at: string;
}
@Injectable({
    providedIn: 'root'
})

export class AppService {
    public user: any = null;
    private apiUrl = 'http://claro_api.test/api'
    constructor(private router: Router, private toastr: ToastrService, private http: HttpClient) {}

    async loginByAuth({email, password}) {
        try {
          console.log('email',email)
            await authLogin(email, password, this.http);
            await this.getProfile();
            this.router.navigate(['/']);
            this.toastr.success('Login success');
        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async registerByAuth({email, password}) {
        try {
          await authLogin(email, password, this.http);
          await this.getProfile();
          this.router.navigate(['/']);
          this.toastr.success('Register success');
        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async loginByGoogle() {
        try {
          this.toastr.warning('Not implemented');

        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async registerByGoogle() {
        try {
          this.toastr.warning('Not implemented');

        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async loginByFacebook() {
        try {
          this.toastr.warning('Not implemented');

        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async registerByFacebook() {
        try {

            this.toastr.warning('Not implemented');
        } catch (error) {
            this.toastr.error(error.message);
        }
    }

    async getProfile() {
        try {
            const user = await getAuthStatus();
            if(user) {
              this.user = user;
            } else {
              this.logout();
            }
          } catch (error) {
          this.logout();
            throw error;
        }
    }

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('authentication');
        this.user = null;
        this.router.navigate(['/login']);
    }
}


export const authLogin = async (email: string, password: string, http: HttpClient ) => {
  return new Promise(async (res, rej) => {
    const credentials = { email, password };
    const response = await http.post<AuthObject>('http://claro_api.test/api/auth/login', credentials).subscribe((data) => {
        if (data.status){
          localStorage.setItem('token', data.access_token);
          localStorage.setItem(
            'authentication',
            JSON.stringify({ profile: { email: data.user.email } })
          );
        }

        
    }, (error) => {
      localStorage.removeItem('authentication');
    });
    const profile = await getAuthStatus();
    if(!profile)
      rej({ message: 'Credentials are wrong!' });
    if(profile) {
      res({ profile: { ...profile as Object } });
    }
    
  });
};

export const getAuthStatus = () => {
  return new Promise(async (res, rej) => {
    await sleep(500);
    try {
      let authentication = localStorage.getItem('authentication');
      if (authentication) {
        authentication = JSON.parse(authentication);
        return res(authentication);
      }
      return res(undefined);
    } catch (error) {
      return res(undefined);
    }
  });
};
