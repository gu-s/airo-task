import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup } from '@angular/forms';
import { QuotationService } from 'src/app/shared/quotation.service';

// User interface
export class QuotationResponse {
  total: any;
  quotation_id: any;
  currency_id: any;
}
@Component({
  selector: 'app-quotation',
  templateUrl: './quotation.component.html',
  styleUrls: ['./quotation.component.scss'],
})
export class QuotationComponent implements OnInit {
  quotationForm: FormGroup;
  showQuotation: boolean = false;
  quotation!: QuotationResponse;
  errors:any = null;
  constructor(
    public router: Router,
    public fb: FormBuilder,
    public quotationService: QuotationService,
  ) {
    this.quotationForm = this.fb.group({
      age: [],
      currency_id: [],
      start_date: [],
      end_date: [],
    });
  }
  ngOnInit() {}
  onSubmit() {
    this.errors = null;
    this.quotation = new QuotationResponse();
    this.showQuotation = false;
    this.quotationService.getQuotation(this.quotationForm.value).subscribe(
      (result) => {
        this.quotation = result.data;
        this.showQuotation = true;
      },
      (error) => {
        this.errors = error.error.data;
      },
      () => {
        this.quotationForm.reset();
      }
    );
  }

}