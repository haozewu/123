int main()
{
  unsigned int *pGPFCON=(unsigned int *)0x56000050;
  unsigned int *pGPFDAT=(unsigned int *)0X56000054;
  
  *pGPFCON=0X100;
  
  *pGPFDAT=0;
  return 0;
}
