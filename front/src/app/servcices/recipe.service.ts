import { Injectable } from '@angular/core';
import { Observable, from } from 'rxjs';

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
          console.log('Recipe created:', data);
          return data;
        })
        .catch(error => {
          console.error('Create recipe error:', error);
          throw error;
        })
    );
  }

  addRecipeView(recipeId: number): Observable<any> {
    const token = localStorage.getItem('token');
    if (!token) {
      throw new Error('User is not authenticated');
    }
    return from(
      fetch(`http://localhost:8000/api/recipe/add-view/${recipeId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      })
        .then(response => {
          if (!response.ok) {
            return response.json().then(err => {
              throw new Error(err.message || 'Failed to increment view count');
            });
          }
          return response.json();
        })
        .then((data) => {
          console.log('View incremented:', data);
          return data;
        })
        .catch(error => {
          console.error('Add view error:', error);
          throw error;
        })
    );
  }
}
