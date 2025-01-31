import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, from, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { User } from '../../../models/user.model';
import { clearUser, setUser } from '../stores/user/user.actions';
import { Store } from '@ngrx/store';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private baseUrl = 'http://localhost:8000/api';

  constructor(private router: Router, private store: Store) {}

  getUserInfo(token: string): Observable<User> {
    return from(
      fetch(`${this.baseUrl}/user_infos`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data) {
            const user: User = {
              username: data.email,
              roles: data.roles,
              recipes: data.userRecipes
            }
            this.store.dispatch(setUser({ user }));
            return user
          } else {
            throw new Error('User data not found');
          }
        })
        .catch((error) => {
          console.error('Erreur lors de la récupération des infos utilisateur:', error);
          throw error;
        })
    );
  }
  validateToken(): Observable<boolean> {
    if (typeof localStorage === 'undefined') {
      return of(false);
    }

    const token = localStorage.getItem('token');
    if (!token) {
      return of(false);
    }

    return from(
      fetch(`${this.baseUrl}/validate-token`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.isValid) {
            this.getUserInfo(token);
            const user: User = {
              username: data.user.username,
              roles: data.user.roles,
              recipes: []
            };
            this.store.dispatch(setUser({ user }));
            return true; 
          } else {
            return false; 
          }
        })
        .catch((error) => {
          console.error('Erreur de validation du token:', error);
          return false;
        })
    );
  }

  logout() {
    localStorage.removeItem('token');
    this.store.dispatch(clearUser());
    this.router.navigate(['/login']);
  }

  login(credentials: { email: string; password: string }): Promise<any> {
    return fetch(`${this.baseUrl}/login_check`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(credentials),
    })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(err.message || 'Failed to log in');
          });
        }
        return response.json();
      })
      .then((data) => {
        localStorage.setItem('token', data.token);  
        this.router.navigate(['/home']); 
      })
      .catch(error => {
        console.error('Login error:', error);
        throw error;
      });
  }

  register(user: any): Promise<any> {
    return fetch(`${this.baseUrl}/register`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user),
    })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(err.message || 'Failed to register');
          });
        }
        return response.json();
      })
      .then((data) => {
        this.router.navigate(['/login']);
      })
      .catch(error => {
        console.error('Register error:', error);
        throw error;
      });
  }
}
