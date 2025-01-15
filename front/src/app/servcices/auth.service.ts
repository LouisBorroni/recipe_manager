import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private baseUrl = 'http://localhost:8000/api';

  constructor() {}

  login(credentials: { username: string; password: string }): Promise<any> {
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
      .catch(error => {
        console.error('Register error:', error);
        throw error;
      });
  }
}
