import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private baseUrl = 'http://localhost:8000/api';

  constructor(private router: Router) {}

  validateToken(): Observable<boolean> {
    if (typeof localStorage === 'undefined') {
      return of(false);
    }
    const token = localStorage.getItem('token');
    if (!token) {
      return of(false); 
    }

    return new Observable<boolean>((observer) => {
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
            observer.next(true); 
          } else {
            observer.next(false); 
          }
          observer.complete();
        })
        .catch((error) => {
          console.error('Erreur de validation du token:', error);
          observer.next(false); 
          observer.complete();
        });
    });
  }

  logout() {
    localStorage.removeItem('token');
    this.router.navigate(['/login']);
  }

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
      .then((data) => {
        // Enregistrez le token reçu après une connexion réussie
        localStorage.setItem('token', data.token);  // Assurez-vous que vous recevez un token dans la réponse

        // Redirigez l'utilisateur vers la page d'accueil après la connexion réussie
        console.log('User logged in successfully!');
        this.router.navigate(['/home']);  // Redirection vers la page d'accueil
        return data;  // Retourne la réponse après la redirection
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
        console.log('User registered successfully!');
        this.router.navigate(['/login'])
      })
      .catch(error => {
        console.error('Register error:', error);
        throw error;
      });
  }
}
