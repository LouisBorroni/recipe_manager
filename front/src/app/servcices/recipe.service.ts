import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, from } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class RecipeService {
  private baseUrl = 'http://localhost:8000/api/recipes';

  constructor() {}

  createRecipe(recipeData: any): Observable<any> {
    const token = localStorage.getItem('token');
    if (!token) {
      throw new Error('User is not authenticated');
    }

    return from(
      fetch(this.baseUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify({
          name: recipeData.name,
          category: recipeData.category,
          image: recipeData.image, // Image en base64
          cookingSteps: recipeData.cookingSteps,
        }),
      })
        .then(response => {
          if (!response.ok) {
            return response.json().then(err => {
              throw new Error(err.message || 'Failed to create recipe');
            });
          }
          return response.json();
        })
        .then((data) => {
          console.log('Recipe created:');
          return data;
        })
        .catch(error => {
          console.error('Create recipe error:', error);
          throw error;
        })
    );
  }
}
