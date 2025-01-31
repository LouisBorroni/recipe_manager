import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecipeCreationModalComponent } from './recipe-creation-modal.component';

describe('RecipeCreationModalComponent', () => {
  let component: RecipeCreationModalComponent;
  let fixture: ComponentFixture<RecipeCreationModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RecipeCreationModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecipeCreationModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
