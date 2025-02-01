import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecipeModaleComponent } from './recipe-modale.component';

describe('RecipeModaleComponent', () => {
  let component: RecipeModaleComponent;
  let fixture: ComponentFixture<RecipeModaleComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RecipeModaleComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecipeModaleComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
