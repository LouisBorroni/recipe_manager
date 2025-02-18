import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { AuthService } from '../servcices/auth.service';
import { catchError, map, Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}

  canActivate(): Observable<boolean> {
    return this.authService.validateToken().pipe(
      map((isValid) => {
        if (isValid) {
          return true;
        } else {
          this.router.navigate(['/loading']);
          return false;
        }
      }),
      catchError(() => {
        this.router.navigate(['/register']);
        return of(false);
      })
    );
  }
}

