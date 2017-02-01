#include "HX711.h"

HX711 scale;

long initial = 0;
long onekg = 0;
void setup()
{
  
  scale.begin(A1,A0);
  Serial.begin(9600);
  
  scale.read();
  
  Serial.println("Initialization Done ");
}
int k =0;
double one_kg_no;
void loop()
{
  if(k<5){
  Serial.println("Remove Anything from scale : "); Serial.print("   ");
  for(int i=0 ;i<5;i++){
    Serial.print(5 - i); Serial.print("... ");
    delay(1000);}
    initial += scale.read_average(20);
    
    Serial.println("Place 1 Kg on scale : "); Serial.print("   ");
  for(int i=0 ;i<5;i++){
    Serial.print(5 - i); Serial.print("... ");
    delay(1000);}
    onekg += scale.read_average(20);
  k++;
  }
  if( k == 5)
  {
    initial = initial/k;
    onekg = onekg/k;
    k++;
  }
  if(k > 5)
  {
    one_kg_no = onekg - initial;
     Serial.print("Value on scale is "); Serial.println((scale.read_average(20) - initial)/one_kg_no);
    
  }
  scale.power_down();
  delay(500);
  scale.power_up();
  
}

