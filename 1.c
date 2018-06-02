void main()
{
  unsigned int *pGPFCON=0x56000050;
  unsigned int *pGPFDAT=0X56000054;
  
  *pGPFCON=0X100;
  
  *pGPFDAT=0;
}
