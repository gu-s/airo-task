import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
// User interface
export class QuotationRequest {
  age!: String;
  currency_id!: String;
  start_date!: String;
  end_date!: String;
}
@Injectable({
  providedIn: 'root',
})
export class QuotationService {
  constructor(private http: HttpClient) {}
  // User registration
  getQuotation(quoteRequest: QuotationRequest): Observable<any> {
    return this.http.post('http://127.0.0.1:8000/api/quotation', quoteRequest);
  }
  

}